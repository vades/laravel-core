<?php

namespace App\Services\Album;

class AlbumDataResource
{
    public array $data = [];
    public string $message = '';
    public string $createdAt = '';
    public array $meta = [
        'total' => 0,
    ];
}