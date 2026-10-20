<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class HeroRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'hero';
        return view("widgets.$view", [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
