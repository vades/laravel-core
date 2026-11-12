<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class AlbumRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'album';
        return view("widgets.$view", [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
