<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class WidgetRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        return view('widgets.widget', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
