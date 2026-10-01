<?php

namespace App\Enums;

use App\Services\Widgets\Renderers\FeatureRenderer;
use App\Services\Widgets\Renderers\LivewireRenderer;
use App\Services\Widgets\Renderers\WidgetRenderer;

enum WidgetContentType: string
{
    case Widget = 'widget';
    case Livewire = 'livewire';
    case Feature = 'feature';

    public function renderer(): string
    {
        return match ($this) {
            self::Widget => WidgetRenderer::class,
            self::Livewire => LivewireRenderer::class,
            self::Feature => FeatureRenderer::class,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
