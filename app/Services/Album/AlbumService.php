<?php

namespace App\Services\Album;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AlbumService
{

    public static function getData($path): array
    {

        $fullPath = config('myapp.album.storageDir').'/' . $path;
        if (!file_exists($fullPath)) {
            Log::error("File not found: {$fullPath}");
            return [];
        }
        try {
            $content = file_get_contents($fullPath);
            $data = json_decode($content);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("JSON decode error in file: {$fullPath} - Error: " . json_last_error_msg());
                return [];
            }
            return $data->data ?? [];
        } catch (\Throwable $e) {
            Log::error("Error reading file {$fullPath}: " . $e->getMessage());
            return [];
        }
    }

    public static function getAlbums(): array
    {
       return self::getData(config('myapp.album.file.albums'));
    }

    public static function getEvents(string $event): array
    {
        return self::getData($event .'/'.config('myapp.album.file.events'));
    }

    public static function getImages(string $event): array
    {
        return self::getData($event .'/'.config('myapp.album.file.images'));
    }


}
