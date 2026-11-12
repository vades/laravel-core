<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

abstract class AbstractWidgetRenderer
{
    abstract public function render(
        Widget $widget,
        array $options = []
    ): string;
}
