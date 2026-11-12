<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class LivewireRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {

        return view('widgets.livewire', [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
