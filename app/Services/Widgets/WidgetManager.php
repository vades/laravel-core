<?php

namespace App\Services\Widgets;

use App\Models\Widget;
use Illuminate\Support\Facades\Cache;

class WidgetManager
{
    public function render(
        string $slug,
        array $options = []
    ): string {
        /* $widget = Cache::remember(
            "widget:{$slug}",
            now()->addHour(),
            fn () => Widget::query()
                ->publishedByType()
                ->where('slug', $slug)
                ->first()
        ); */

        $widget = Widget::publishedByType()
                ->where('slug', $slug)
                ->first();

        if (!$widget) {
            return '';
        }

        $rendererClass = $widget->content_type->renderer();

        return app($rendererClass)
            ->render($widget, $options);
    }
}
