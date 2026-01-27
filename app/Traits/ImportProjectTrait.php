<?php

namespace App\Traits;

use App\Services\Album\AlbumService;
use App\Utils\Utils;
use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\YamlFrontMatter\Document;
use Spatie\YamlFrontMatter\YamlFrontMatter;

trait ImportProjectTrait
{

    private string $project;
    private array $files = [];

    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    private array $success = [];
    public function getSuccess(): array
    {
        return $this->success;
    }


    private string $pathToDir;

    private array $directories = [];
    private function parseImportDir(): void
    {

        if (!config()->has('myapp.projects.' . $this->project)) {
            throw new Exception('No valid project name: ' . $this->project);
        }
        if (!is_dir($this->pathToDir)) {
            throw new Exception('Failed to read files from directory: ' . $this->pathToDir);
        }

        $directories = array_filter(glob($this->pathToDir . '/*'), 'is_dir');
        if (empty($directories)) {
            throw new Exception('No directories found in: ' . $this->pathToDir);
        }

        $this->directories = array_map('basename', $directories);
    }

    private function parseImportFiles(): void
    {
        foreach ($this->directories as $directory) {
            $path = $this->pathToDir . $directory;
            $files = glob($path . '/*.md');
            if (empty($files)) {
                $this->errors[] = 'WARNING: No files found in directory: ' . $path;
                continue;
            }
            $this->files[$directory] = $files;
        }
    }

    private function parseMarkdownFiles(): void
    {
        foreach ($this->files as $contentType => $files) {
            foreach ($files as $file) {
                $content = file_get_contents($file);
                if ($content === false) {
                    array_push($this->errors, 'Failed to read file: ' . $file);
                    continue;
                }
                $object = YamlFrontMatter::parse($content);
                $this->parseMarkdown($object, $contentType);

            }
        }
    }
    // Function takes all $object properties that are not listed in $data properties and creates an array that
    // will be the content of options.

    private function parseOptions(Document $object, $data): void
    {
        $data->options = array_filter((array) $object->matter(), function ($key) use ($data) {
            return !property_exists($data, $key) && strpos($key, "\x00*\x00") === false;
        },
                                      ARRAY_FILTER_USE_KEY
        );
    }

    private function getThumbImageUrl(string $album, string $event): string
    {
        $url = '';
        $path = config('myapp.album.dir.target') . '/' . $album . '/' . $event. '/' . config('myapp.album.cover');
        if (file_exists($path) ) {
            $url = config('myapp.album.url'). '/' . $album . '/' . $event . '/' . config('myapp.album.cover');
        }
        return $url;
        //return Utils::urlExists($url);
    }
    private function getFeaturedImageUrl(string $album, string $event): string
    {
        $url = '';
        $path = config('myapp.album.dir.target') . '/' . $album . '/' . $event. '/' . config('myapp.album.featured');
        if (file_exists($path) ) {
            $url = config('myapp.album.url'). '/' . $album . '/' . $event . '/' . config('myapp.album.featured');
        }
        return $url;
        //return Utils::urlExists($url);
    }

    private function getPlaceImageUrl(string $album, string $event): string
    {
        $url = '';
        $path = config('myapp.album.dir.target') . '/' . $album . '/' . $event. '/' . config('myapp.album.cover');
        if (file_exists($path) ) {
            $url = config('myapp.album.url'). '/' . $album . '/' . $event . '/' . config('myapp.album.cover');
        }
       return $url;
        //return Utils::urlExists($url);
    }
    private function getPlaceFeaturedImageUrl(string $album, string $event): string
    {
        $url = '';
        $path = config('myapp.album.dir.target') . '/' . $album . '/' . $event. '/' . config('myapp.album.featured');
        if (file_exists($path) ) {
            $url = config('myapp.album.url'). '/' . $album . '/' . $event . '/' . config('myapp.album.featured');
        }
        return $url;
        //return Utils::urlExists($url);
    }

    private function logErrors(): void
    {
        if(!empty($this->getErrors())) {
            Log::error('Some errors occurred while importing data for project: ' . $this->project);
            foreach ($this->getErrors() as $error) {
                Log::error($error);
            }
        }
    }

    private function logSuccess(): void
    {
        foreach ($this->getSuccess() as $log) {
            Log::info($log);
        }
    }
}