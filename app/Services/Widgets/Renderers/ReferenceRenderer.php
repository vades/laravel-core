<?php

namespace App\Services\Widgets\Renderers;

use App\Models\Widget;
use App\Queries\ContentQuery;
use App\Enums\ContentContentType;
class ReferenceRenderer extends AbstractWidgetRenderer
{
    public function render(
        Widget $widget,
        array $options = []
    ): string {
        $view = $options['view'] ?? 'reference';

        $references = new ContentQuery(ContentContentType::Reference);
        return view("widgets.$view", [
            'widget' => $widget,
            'options' => $options,
            'references' =>  $references->latest(take: 6),
        ])->render();
    }
}
