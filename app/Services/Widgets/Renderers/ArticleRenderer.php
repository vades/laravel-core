<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;

class ArticleRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'article';
        return view("widgets.$view", [
            'widget' => $widget,
            'options' => $options,
        ])->render();
    }
}
