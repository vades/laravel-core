<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;

trait HasDynamicContent
{
    /**
     * Render Markdown content with support for Blade components and dynamic variables.
     *
     * @param array $data
     * @param string $column The database column name (e.g., 'content')
     * @return string
     */
    public function renderContent(array $data = [], string $column = 'content'): string
    {
        $raw = $this->{$column};

        if (empty($raw)) {
            return '';
        }

        // 1. Render the Blade tags first
        $renderedBlade = Blade::render($raw, $data);

        /**
         * 2. Fix: Remove leading indentation.
         * We use regex to remove spaces/tabs from the start of every line.
         * This prevents Markdown from turning indented HTML into <pre><code> blocks.
         */
        $cleanedHtml = preg_replace('/^[ \t]+/m', '', $renderedBlade);

        // 3. Render as Markdown
        return Str::markdown($cleanedHtml);
    }
}