<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class FeatureRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        return view('widgets.feature', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
