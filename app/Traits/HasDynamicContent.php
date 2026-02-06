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
    public function renderContent(array $data = [],string $column = 'content'): string
    {
        $raw = $this->{$column};

        if (empty($raw)) {
            return '';
        }

        $html = Blade::render($raw , $data);
        return Str::markdown($html);
    }
}