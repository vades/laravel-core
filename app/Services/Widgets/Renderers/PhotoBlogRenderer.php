<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;
use App\Services\Album\AlbumService;

class PhotoBlogRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'photo-blog';
        $path = $options['path'] ?? null;

        if (!is_string($path) || trim($path) === '') {
            return '';
        }

        $parts = explode('/', trim($path, '/'));

        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            return '';
        }

        [$album, $event] = $parts;

        $view = $options['view'] ?? 'photo-blog';
        $take = (int) ($options['take'] ?? 0);

        $images = collect(AlbumService::getImages($album))
            ->where('directory', $event)
            ->when($take > 0, fn($q) => $q->take($take))
            ->values()
            ->toArray();

        if (empty($images)) {
            return '';
        }

        return view("widgets.$view", [
            'widget'  => $widget,
            'options' => $options,
            'images'  => $images,
        ])->render();
    }
}
