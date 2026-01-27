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
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Spatie\YamlFrontMatter\Document;

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

    public function __construct()
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
        $projectId = 6;//config("myapp.projects.{$projectName}");

        if (!$projectId) {
            $this->errors[] = "Project configuration missing for: {$projectName}";
            return;
        }

        $contentTypes = File::directories($contentPath);

        foreach ($contentTypes as $typePath) {
            $contentTypeStr = basename($typePath);
            $this->processContentType($projectId, $contentTypeStr, $typePath);
        }
    }

    /**
     * Process subdirectories like 'articles', 'categories', 'tags'.
     */
    private function processContentType(int $projectId, string $contentTypeStr, string $path): void
    {
        $files = File::files($path);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }

            try {
                $this->importFile($projectId, $contentTypeStr, $file->getPathname());
            } catch (Exception $e) {
                $this->errors[] = "File error [{$file->getFilename()}]: " . $e->getMessage();
            }
        }
    }

    /**
     * Parse the Markdown file and store it using the appropriate DTO.
     */
    private function importFile(int $projectId, string $contentTypeStr, string $filePath): void
    {
        $fileContent = file_get_contents($filePath);
        if ($fileContent === false) {
            throw new Exception("Could not read file.");
        }

        $object = YamlFrontMatter::parse($fileContent);

        // Basic validation: ensure we have at least a title or slug
        if (!$object->matter('title') && !$object->matter('slug')) {
            throw new Exception("Missing required YAML front matter (title or slug).");
        }

        $this->handleContentImport($projectId, $contentTypeStr, $object);
    }

    /**
     * Handle generic content (articles, posts, etc.)
     */
    private function handleContentImport(int $projectId, string $contentTypeStr, Document $object): void
    {
        try {
            // Map YAML to ContentData DTO
            $data = [
                'uuid' => $object->matter('uuid') ?? (string) Str::uuid(),
                'projectId' => $projectId,
                'userId' => $object->matter('user_id') ?? 1,
                'authorId' => $object->matter('author_id'),
                'parentId' => $object->matter('parent_id'),
                'contentType' => ContentContentType::tryFrom($contentTypeStr) ?? ContentContentType::Article,
                'status' => $object->matter('is_published') ? ContentStatus::Published : ContentStatus::Draft,
                'visibility' => ContentVisibility::tryFrom($object->matter('visibility') ?? 'public') ?? ContentVisibility::Public,
                'lang' => $object->matter('lang') ?? 'en',
                'slug' => $object->matter('slug') ?? Str::slug($object->matter('title')),
                'title' => (string) $object->matter('title'),
                'subtitle' => $object->matter('subtitle'),
                'excerpt' => $object->matter('description') ?? $object->matter('excerpt'),
                'content' => $object->body(),
                'metadata' => $this->extractMetadata($object, ['title', 'slug', 'description', 'is_published']),
                'position' => (int) ($object->matter('position') ?? 0),
                'isFeatured' => (bool) ($object->matter('is_featured') ?? false),
                'publishedAt' => $object->matter('published_at') ? Carbon::parse($object->matter('published_at')) : null,
            ];

            $dto = ContentData::from($data);

            Content::updateOrCreate(
                ['slug' => $dto->slug, 'project_id' => $dto->projectId],
                $dto->toArray()
            );

            $this->success[] = "Imported Content: {$dto->title}";
        } catch (Exception $e) {
            $this->errors[] = "Content Save Error [{$object->matter('title')}]: " . $e->getMessage();
        }
    }

    private function storeContent(ContentData $dto): void
    {

    }

    private function createCategoryContent()
    {

    }

    private function creatTag()
    {

    }

    private function createContentTag()
    {

    }

    /**
     * Handle Category specific import
     */
    private function handleCategoryImport(int $projectId, Document $object): void
    {
        try {
            $data = [
                'uuid' => $object->matter('uuid') ?? (string) Str::uuid(),
                'projectId' => $projectId,
                'parentId' => $object->matter('parent_id'),
                'status' => $object->matter('is_published') ? ContentStatus::PUBLISHED : ContentStatus::DRAFT,
                'visibility' => ContentVisibility::PUBLIC,
                'contentType' => ContentContentType::CATEGORY,
                'position' => (int) ($object->matter('position') ?? 0),
                'slug' => $object->matter('slug') ?? Str::slug($object->matter('title')),
                'lang' => Language::tryFrom($object->matter('lang') ?? 'en') ?? Language::EN,
                'title' => (string) $object->matter('title'),
                'excerpt' => $object->matter('description'),
                'metadata' => $this->extractMetadata($object, ['title', 'slug']),
            ];

            $dto = CategoryData::from($data);

            Category::updateOrCreate(
                ['slug' => $dto->slug, 'project_id' => $dto->projectId],
                $dto->toArray()
            );

            $this->success[] = "Imported Category: {$dto->title}";
        } catch (Exception $e) {
            $this->errors[] = "Category Save Error: " . $e->getMessage();
        }
    }

    /**
     * Handle Tag specific import
     */
    private function handleTagImport(int $projectId, Document $object): void
    {
        try {
            $dto = TagData::from([
                                     'projectId' => $projectId,
                                     'contentType' => ContentContentType::TAG,
                                     'lang' => $object->matter('lang') ?? 'en',
                                     'name' => $object->matter('title') ?? $object->matter('name'),
                                 ]);

            Tag::updateOrCreate(
                ['name' => $dto->name, 'project_id' => $dto->projectId],
                $dto->toArray()
            );

            $this->success[] = "Imported Tag: {$dto->name}";
        } catch (Exception $e) {
            $this->errors[] = "Tag Save Error: " . $e->getMessage();
        }
    }

    /**
     * Extracts keys from YAML that aren't part of the primary DTO properties.
     */
    private function extractMetadata(Document $object, array $excludeKeys): array
    {
        return array_filter($object->matter(), function ($key) use ($excludeKeys) {
            return !in_array($key, $excludeKeys);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Log results of the import.
     */
    private function logSummary(): void
    {
        foreach ($this->success as $msg) {
            Log::info($msg);
            // Optionally print to console if running via command
            // echo "SUCCESS: $msg\n";
        }

        if (!empty($this->errors)) {
            Log::error("Import completed with errors:");
            foreach ($this->errors as $error) {
                Log::error($error);
                // echo "ERROR: $error\n";
            }
        }
    }
}