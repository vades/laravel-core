<?php

namespace App\Services\Content;

use App\Services\Widgets\WidgetManager;

class ShortcodeParser
{
    public function __construct(
        private WidgetManager $widgetManager
    ) {
    }

   public function parse(string $content): string
    {
        return preg_replace_callback(
            '/\{%\s*([a-zA-Z0-9\-_]+)(.*?)\s*%\}/',
            function ($matches) {
                $slug = $matches[1];

                $options = $this->parseAttributes($matches[2]);

                return $this->widgetManager->render($slug, $options);
            },
            $content
        );
    }

    private function parseAttributes(
        string $attributes
    ): array {

        preg_match_all(
            '/(\w+)="([^"]*)"/',
            $attributes,
            $matches,
            PREG_SET_ORDER
        );

        $result = [];

        foreach ($matches as $match) {
            $result[$match[1]] = $match[2];
        }

        return $result;
    }
}
