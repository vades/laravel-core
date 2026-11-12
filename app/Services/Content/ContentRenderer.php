<?php

namespace App\Services\Content;

use Illuminate\Support\Str;

class ContentRenderer
{
    public function render(string $content): string
    {
        $content = app(ShortcodeParser::class)->parse($content);

        $content = preg_replace('/^[ \t]+/m', '', $content);

        return Str::of($content)->markdown();
    }
}
