<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;
use App\Services\Album\AlbumService;
use App\Services\Widgets\Renderers\AbstractWidgetRenderer;

class GalleryRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'gallery';
        $path = $options['path'] ?? null;
        $take = $options['limit'] ?? 1;
        $schuffle = $options['schuffle'] ?? false;

        if (!is_string($path) || trim($path) === '') {
            return '';
        }

        $parts = explode('/', trim($path, '/'));

        /*  if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            return '';
        } */

        [$album, $event] = $parts;

        $take = (int) ($options['take'] ?? 0);

        $images = collect(AlbumService::getImages($album))
            ->when(!empty($event), fn($q) => $q->where('directory', $event))

            ->when($take > 0, fn($q) => $q->take($take))
            ->when($schuffle, fn($q) => $q->shuffle())
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
