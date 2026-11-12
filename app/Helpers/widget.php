<?php

use App\Services\Widgets\WidgetManager;

if (! function_exists('widget')) {

    function widget(
        string $slug,
        array $options = []
    ): string {
        return app(WidgetManager::class)
            ->render($slug, $options);
    }
}
