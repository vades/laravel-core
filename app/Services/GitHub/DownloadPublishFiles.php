<?php

namespace App\Services\GitHub;

use Illuminate\Support\Facades\Http;

class DownloadPublishFiles
{
    private const OWNER  = 'vades';
    private const REPO   = 'publishing';
    private const BRANCH = 'master';

    public static function getFileList(): array
    {
        $url = sprintf(
            'https://api.github.com/repos/%s/%s/git/trees/%s?recursive=1',
            self::OWNER, self::REPO, self::BRANCH
        );

        $response = Http::withHeaders([
            'Accept'     => 'application/vnd.github+json',
            'User-Agent' => 'Laravel',
        ])->get($url);

        if ($response->status() === 404) {
            throw new \RuntimeException(
                sprintf(
                    'Repository "%s/%s" not found or branch "%s" does not exist.',
                    self::OWNER, self::REPO, self::BRANCH
                )
            );
        }

        if ($response->failed()) {
            throw new \RuntimeException(
                'GitHub API error [' . $response->status() . ']: ' . $response->body()
            );
        }

        return collect($response->json('tree', []))
            ->where('type', 'blob')
            ->pluck('path')
            ->values()
            ->all();
    }

    public static function downloadFiles(array $paths, callable $onFile = null): array
    {
        $results = [];

        foreach ($paths as $path) {
            try {
                $url = sprintf(
                    'https://raw.githubusercontent.com/%s/%s/%s/%s',
                    self::OWNER, self::REPO, self::BRANCH, $path
                );

                $content = Http::get($url)->throw()->body();

                $destination = storage_path('app/imports/' . $path);

                // Create directories if they don't exist
                $directory = dirname($destination);
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($destination, $content);

                $results[$path] = true;
            } catch (\Throwable $e) {
                $results[$path] = $e->getMessage();
            }

            if ($onFile) {
                $onFile($path, $results[$path]);
            }
        }

        return $results;
    }
}
