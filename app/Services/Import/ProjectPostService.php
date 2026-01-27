<?php

namespace App\Services\Import;

use App\Data\PostData;
use App\Data\TagData;
use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\ImportProjectTrait;
use Exception;
use Spatie\YamlFrontMatter\Document;


class ProjectPostService
{
    use ImportProjectTrait;

    /**
     * @throws Exception
     */
    public function __construct(string $project)
    {

        $this->project = $project;
        $this->pathToDir = storage_path() . '/app/imports/projects/' . $project . '/posts/';
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        try {
            $this->parseImportDir();
            $this->parseImportFiles();
            $this->parseMarkdownFiles();
            $this->logErrors();
            $this->logSuccess();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function parseMarkdown(Document $object, string $contentType): void
    {

        $data = new \stdClass();
        $data->options = [];
        $data->parent_id = $this->getParentId($object->parent_id,$contentType);
        $data->project_id = $object->project_id ?? config('myapp.projects.' . $this->project);
        $data->user_id = $object->user_id ?? 1;
        $data->is_featured = $object->is_featured ?? false;
        $data->post_type = $contentType;
        $data->post_status = $object->post_status ?? PostStatus::DRAFT;
        $data->position = $object->position ?? 0;
        $data->views_count = $object->views_count ?? 0;
        $data->lang = $object->lang ?? app()->getLocale();
        $data->title = str($object->title)->squish()->toString();
        $data->subtitle = str($object->subtitle)->squish()->toString() ?? '';
        $data->description = str($object->description)->squish()->toString() ?? '';
        $data->content = $object->body();
        $data->image_url = (function($url, $contentType, $project, $slug, $eventDirectory) {
            if ($contentType === 'post') {
                return $this->getThumbImageUrl($project . '-'.$contentType,  $eventDirectory);
            }elseif ($contentType === 'place') {
                return $this->getThumbImageUrl($project, $slug);
            }else{
                return $url;
            }

        })($object->image_url ?? '', $contentType, $this->project, $object->slug,  $object->eventDirectory ?? '');
        $data->tags = $object->tags ?? null;
        $data->categories = $object->categories ?? null;
        $data->slug = $object->slug ?? null;
        $data->created_at = $object->created_at ?? null;
        $data->updated_at = $object->updated_at ?? null;
        $this->parseOptions($object, $data);

        $featuredImage = (function($url, $contentType, $project, $slug,$eventDirectory) {
            if ($contentType === 'post') {
                return $this->getFeaturedImageUrl($project . '-'.$contentType, $eventDirectory);
            }elseif ($contentType === 'place') {
                return $this->getFeaturedImageUrl($project, $slug);
            }else{
                return $url;
            }
        })($object->image_url ?? '', $contentType, $this->project, $object->slug,  $object->eventDirectory ?? '');

        if(!empty($featuredImage)) {
            $data->options['featuredImage'] = $featuredImage;
        }
        $post = null;

        try {
            $validatedData = PostData::validateAndCreate((array)$data);
            $post = $this->storeData($validatedData);
        } catch (Exception $e) {
            $this->errors[] = 'ERROR: Unable to parse post narkdown data for project: '  . $data->project_id . ' | ' . $data->title . ' | '.  $data->slug;
            $this->errors[] = $e->getMessage();
        }

        if (!is_null($post)) {
            if (is_string($data->categories) && !empty($data->categories)) {
                $categoriesIds = $this->parseCategories($data->categories, $post);
                if (count($categoriesIds) > 0) {
                    $post->categories()->sync($categoriesIds);
                }
            }

            if (is_string($data->tags) && $data->tags !== '') {
                $tagsIds = $this->parseTags($data->tags, $post);
                if (count($tagsIds) > 0) {
                    $post->tags()->sync($tagsIds);
                }

            }

        }


    }

    private function storeData(PostData $data): Post|null
    {
        try {
            $post = Post::updateOrCreate(
                ['slug' => $data->slug],
                [
                    'parent_id' => $data->parent_id,
                    'project_id' => $data->project_id,
                    'user_id' => $data->user_id,
                    'slug' => $data->slug,
                    'is_featured' => $data->is_featured,
                    'post_type' => $data->post_type,
                    'post_status' => $data->post_status->value,
                    'position' => $data->position,
                    'views_count' => $data->views_count,
                    'lang' => $data->lang,
                    'title' => $data->title,
                    'subtitle' => $data->subtitle,
                    'description' => $data->description,
                    'content' => $data->content,
                    'image_url' => $data->image_url,
                    'options' => json_encode($data->options, JSON_UNESCAPED_UNICODE),
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                ]
            );
            /* $this->success[] = 'SUCCESS: '.$data->post_type.' saved for project: ' . $data->project_id . ' | ' .
                 $data->title . ' | ' .
                 $data->slug;*/
            return $post;
        } catch (Exception $e) {
            $this->errors[] = 'ERROR: Unable to save '.$data->post_type.' for project: ' . $data->project_id . ' | ' . $data->title
                . ' | ' . $data->slug;
            $this->errors[] = $e->getMessage();

        }
        return null;
    }


    private function parseCategories(string $categories, Post $post): array
    {

        $categorySlugs = array_map('trim', explode(',', $categories));
        $categories = [];
        foreach ($categorySlugs as $slug) {
            $category = Category::where('slug', $slug)->publishedByType($post->post_type)->first();
            if (is_null($category)) {
                $backtrace = debug_backtrace();
                $caller = $backtrace[0];
                $this->errors[] = 'ERROR: Category not found: category slug = "' . $slug . '" | post slug "'.$post->slug. '"  for in ' . $caller['file'] . ' on line ' . $caller['line'];
                continue;
            }
            $categories[] = $category->id;
        }
        return $categories;
    }

    private function getParentId(string|null $parentSlug, string $postType): int
    {
        if(is_null($parentSlug)) {
            return 0;
        }
        $post = Post::where('slug', $parentSlug)->publishedByType($postType)->first();

        if (!$post) {
            return 0;
        }

        return $post->id;
    }

    private function parseTags(string $tags, Post $post): array
    {
        $tagNames = array_map('trim', explode(',', $tags));
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            $tag = $this->storeTag($tagName, TagData::from([
                                                               'project_id' => $post->project_id,
                                                               'is_published' => true,
                                                               'tag_type' => $post->post_type,
                                                               'lang' => $post->lang,
                                                               'views_count' => 0,
                                                               'name' => $tagName,
                                                           ]));
            if (!is_null($tag)) {
                $tagIds[] = $tag->id;
            }
        }
        return $tagIds;
    }

    private function storeTag(string $tagName, TagData $post): Tag|null
    {
        try {
            $tag = Tag::updateOrCreate(
                ['name' => $tagName],
                ['project_id' => $post->project_id,
                    'is_published' => true,
                    'tag_type' => $post->tag_type,
                    'lang' => $post->lang,
                    'views_count' => 0,
                    'name' => $tagName,

                ]
            );
            // $this->success[] = 'SUCCESS: Tag saved for project: ' . $post->project_id . ' | ' . $tagName;
            return $tag;
        } catch (Exception $e) {
            $this->errors[] = 'ERROR: Unable to save tag for project: ' . $post->project_id . ' | ' . $tagName;
            $this->errors[] = $e->getMessage();

        }
        return null;
    }
}