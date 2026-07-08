<?php

declare(strict_types=1);

namespace App\Services\Import;

use App\Data\CategoryData;
use App\Data\ContentData;
use App\Data\TagData;
use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use App\Models\Category;
use App\Models\Content;
use App\Models\Tag;
use App\Services\DomainManagerService;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\Document;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/**
 * Project Content Import Service
 *
 * - Traverses complex directories (projects -> content -> type).
 * - Resolves Project IDs dynamically by using the folder name as a slug via the DomainManagerService.
 * - Parses YAML Front Matter reliably using Spatie\YamlFrontMatter.
 * - Uses DTOs for data integrity with automatic snake_case mapping to match your database columns.
 * - Handles Mass Assignment safely by ensuring the Content model's $fillable array is correctly configured.
 * - Captures Metadata that doesn't fit into standard columns into a JSON blob.
 *
 * Directory structure supported:
 *   content/{contentType}/                     → no category assigned
 *   content/{contentType}/{category-slug}/     → category assigned via directory name
 */
class ProjectContentService
{
    private string $basePath;
    private array $errors = [];
    private array $success = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccess(): array
    {
        return $this->success;
    }

    public function __construct(protected DomainManagerService $domainManager)
    {
        $this->basePath = storage_path('app/imports/projects');
    }

    /**
     * Main entry point to handle the import process.
     */
    public function handle(): void
    {
        try {
            if (!File::isDirectory($this->basePath)) {
                throw new Exception("Import directory not found: {$this->basePath}");
            }

            $projectDirs = File::directories($this->basePath);

            foreach ($projectDirs as $projectPath) {
                $projectName = basename($projectPath);
                $this->processProject($projectName, $projectPath);
            }

            $this->logSummary();
        } catch (Exception $e) {
            Log::error("Import failed: " . $e->getMessage());
        }
    }

    /**
     * Process an individual project directory.
     */
    private function processProject(string $projectName, string $projectPath): void
    {
        $contentPath = $projectPath . DIRECTORY_SEPARATOR . 'content';

        if (!File::isDirectory($contentPath)) {
            Log::warning("Project [{$projectName}] has no 'content' subdirectory. Skipping.");
            return;
        }

        // Get the project ID from config based on folder name
        $this->domainManager->setSlug($projectName);
        $projectId = $this->domainManager->getProjectId();

        if (!$projectId) {
            $this->errors[] = "Project configuration missing for: {$projectName}";
            return;
        }

        $contentTypes = File::directories($contentPath);

        foreach ($contentTypes as $typePath) {
            $contentTypeStr = basename($typePath);
            $this->processContentType($projectId, $contentTypeStr, $typePath, $projectName);
        }
    }

    /**
     * Process a contentType directory, supporting an optional category subdirectory level.
     *
     * Flat structure (no category):
     *   content/article/file.md  →  contentType=article, categorySlug=null
     *
     * Categorised structure:
     *   content/article/my-category/file.md  →  contentType=article, categorySlug='my-category'
     *
     * Both levels can coexist inside the same contentType directory.
     */
    private function processContentType(int $projectId, string $contentTypeStr, string $path, string $projectSlug): void
    {
        // --- Files directly inside the contentType directory (no category) ---
        foreach (File::files($path) as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }

            try {
                $this->importFile($projectId, $contentTypeStr, $file->getPathname(), $projectSlug, null);
            } catch (Exception $e) {
                $this->errors[] = "File error [{$file->getFilename()}]: " . $e->getMessage();
            }
        }

        // --- Files inside category subdirectories ---
        foreach (File::directories($path) as $categoryPath) {
            $categorySlug = basename($categoryPath);

            foreach (File::files($categoryPath) as $file) {
                if ($file->getExtension() !== 'md') {
                    continue;
                }

                try {
                    $this->importFile($projectId, $contentTypeStr, $file->getPathname(), $projectSlug, $categorySlug);
                } catch (Exception $e) {
                    $this->errors[] = "File error [{$file->getFilename()}] (category: {$categorySlug}): " . $e->getMessage();
                }
            }
        }
    }

    /**
     * Parse the Markdown file and store it using the appropriate DTO.
     *
     * @param int    $projectId
     * @param string $contentTypeStr
     * @param string $filePath
     * @param string $projectSlug
     * @param string|null $directoryCategorySlug  Category slug derived from the parent directory name.
     *                                             When set, it takes precedence over the YAML 'categories' field.
     */
    private function importFile(
        int $projectId,
        string $contentTypeStr,
        string $filePath,
        string $projectSlug,
        ?string $directoryCategorySlug
    ): void {
        $fileContent = file_get_contents($filePath);
        if ($fileContent === false) {
            throw new Exception("Could not read file.");
        }

        $object = YamlFrontMatter::parse($fileContent);

        // Basic validation: ensure we have at least a title or slug
        if (!$object->matter('title') && !$object->matter('slug')) {
            throw new Exception("Missing required YAML front matter (title or slug).");
        }

        $content = $this->handleContentImport($projectId, $contentTypeStr, $object, $projectSlug);
        if (!$content) {
            return;
        }

        // Resolve the effective category: directory name wins over YAML front matter.
        $effectiveCategorySlug = $directoryCategorySlug ?? $object->matter('categories');

        $tagIds = $this->createTag($object->matter('tags') ?? '', $content);
        if (count($tagIds) > 0) {
            $content->tags()->sync($tagIds);
        }

        $categoryIds = $effectiveCategorySlug
            ? $this->getCategories($effectiveCategorySlug, $content)
            : [];

        if (count($categoryIds) > 0) {
            $content->categories()->sync($categoryIds);
        }
    }

    /**
     * Handle generic content (articles, posts, etc.)
     */
    private function handleContentImport(int $projectId, string $contentTypeStr, Document $object, string $projectSlug): ?Content
    {
        $content = null;
        $slug = $object->matter('slug') ?? Str::slug($object->matter('title'));
        try {
            // Map YAML to ContentData DTO
            $data = [
                'uuid' => $object->matter('uuid') ?? (string)Str::uuid(),
                'projectId' => $projectId,
                'userId' => $object->matter('user_id') ?? 1,
                'authorId' => $object->matter('author_id'),
                'parentId' => $this->getParentId($object->matter('parent_id'), $contentTypeStr),
                'contentType' => ContentContentType::tryFrom($contentTypeStr) ?? ContentContentType::Article->value,
                'status' => ContentStatus::tryFrom($object->matter('status') ?? '')
                    ?? ContentStatus::Draft,

                'visibility' => ContentVisibility::tryFrom($object->matter('visibility') ?? '')
                    ?? ContentVisibility::Public,

                'lang' => Language::tryFrom($object->matter('lang') ?? '')
                    ?? Language::EN,
                'slug' => $slug,
                'title' => (string)$object->matter('title'),
                'subtitle' => $object->matter('subtitle'),
                'excerpt' => $object->matter('description') ?? $object->matter('excerpt'),
                'content' => $object->body(),
                'metadata' => $this->extractMetadata($object, ['title', 'slug', 'description', 'is_published']),
                'position' => (int)($object->matter('position') ?? 0),
                'isFeatured' => (bool)($object->matter('is_featured') ?? false),
                'publishedAt' => $object->matter('published_at') ? Carbon::parse($object->matter('published_at')) : null,
            ];
            $data['metadata'] = $this->extractMetadata($object, array_keys($data), ['categories', 'tags', 'parent', 'is_featured']);
            $data['metadata']['coverImage'] = $this->getContentImageUrl($projectSlug, $contentTypeStr, ($object->matter('imageDirectory') ?? '') . '/' . config('myapp.image.cover'));
            $data['metadata']['featuredImage'] = $this->getContentImageUrl($projectSlug, $contentTypeStr, ($object->matter('imageDirectory') ?? '') . '/' . config('myapp.image.featured'));
            if ($contentTypeStr === ContentContentType::Place->value) {
                $data['metadata']['coverImage'] = $this->getPlaceImageUrl($projectSlug, $slug, config('myapp.image.cover'));
                $data['metadata']['featuredImage'] = $this->getPlaceImageUrl($projectSlug, $slug, config('myapp.image.featured'));
            }

            $dto = ContentData::from($data);
            $content = Content::updateOrCreate(
                ['slug' => $dto->slug, 'project_id' => $dto->projectId],
                $dto->toArray()
            );
            $this->success[] = "Imported Content: {$dto->title}";
        } catch (Exception $e) {
            $this->errors[] = "Content Save Error [{$object->matter('title')}]: " . $e->getMessage();
        }
        return $content;
    }

    private function getContentImageUrl(string $projectSlug, string $contentType, string $filename): ?string
    {
        $imagePath = storage_path('app/public/images/' . $projectSlug . '/' . $contentType . '/' . $filename);
        if (File::exists($imagePath)) {
            return 'images/' . $projectSlug.'/'.$contentType . '/' . $filename;
        }
        return null;
    }

    private function getPlaceImageUrl(string $albumName, string $eventName, string $filename): ?string
    {
        $imagePath = storage_path('app/public/albums/' . $albumName . '/' . $eventName . '/' . $filename);
        if (File::exists($imagePath)) {
            return 'albums/' . $albumName . '/' . $eventName . '/' . $filename;
        }
        return null;
    }

    private function getParentId(string|null $parentSlug, string $contentType): ?int
    {
        if (empty($parentSlug)) {
            return null;
        }

        return Content::where('slug', $parentSlug)
                      ->publishedByType($contentType)
                      ->value('id');
    }

    private function getCategories(string $categories, Content $content): array
    {
        $categorySlugs = array_map('trim', explode(',', $categories));
        $categoryIds = [];
        foreach ($categorySlugs as $slug) {
            try {
                $category = Category::where('slug', $slug)->publishedByType($content->content_type)->first();
                if (!$category) {
                    continue;
                }
                $this->success[] = 'Found category slug: ' . $slug . ' | content slug "' . $content->slug;
                $categoryIds[] = $category->id;
            } catch (Exception $e) {
                $this->errors[] = "Category Save Error: " . $e->getMessage();
                continue;
            }
        }
        return $categoryIds;
    }

    private function createTag(string $tags, Content $content): array
    {
        $tagNames = array_map('trim', explode(',', $tags));
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            if ($tagName === '') {
                continue;
            }
            try {
                $dto = TagData::from([
                                         'projectId' => $content->project_id,
                                         'contentType' => $content->content_type,
                                         'lang' => $content->lang->value,
                                         'name' => $tagName,
                                     ]);

                $tag = Tag::updateOrCreate(
                    ['name' => $dto->name, 'project_id' => $dto->projectId],
                    $dto->toArray()
                );

                if ($tag) {
                    $tagIds[] = $tag->id;
                }

                $this->success[] = "Imported Tag: {$dto->name}";
            } catch (Exception $e) {
                $this->errors[] = "Tag Save Error: " . $e->getMessage();
                continue;
            }
        }
        return $tagIds;
    }

    /**
     * Extracts metadata from YAML front matter.
     *
     * @param Document $object      The parsed markdown document
     * @param array $excludeKeys    Keys already mapped to DTO/Database columns (e.g., 'title', 'slug')
     * @param array $ignoreKeys     Keys that should be completely discarded (e.g., 'internal_note', 'temp_id')
     * @return array
     */
    private function extractMetadata(Document $object, array $excludeKeys, array $ignoreKeys = []): array
    {
        return array_filter($object->matter(), function ($key) use ($excludeKeys, $ignoreKeys) {
            return !in_array($key, $excludeKeys) && !in_array($key, $ignoreKeys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Log results of the import.
     */
    private function logSummary(): void
    {
        foreach ($this->success as $msg) {
            Log::info($msg);
        }

        if (!empty($this->errors)) {
            Log::error("Import completed with errors:");
            foreach ($this->errors as $error) {
                Log::error($error);
            }
        }
    }
}
