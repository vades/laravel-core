<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class PlaceRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'place';
        return view("widgets.$view", [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
