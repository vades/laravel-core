<?php

namespace App\Enums;

use App\Services\Widgets\Renderers\AlbumRenderer;
use App\Services\Widgets\Renderers\ArticleRenderer;
use App\Services\Widgets\Renderers\ContactFormRenderer;
use App\Services\Widgets\Renderers\FeatureRenderer;
use App\Services\Widgets\Renderers\LivewireRenderer;
use App\Services\Widgets\Renderers\PageRenderer;
use App\Services\Widgets\Renderers\PlaceRenderer;
use App\Services\Widgets\Renderers\ReferenceRenderer;
use App\Services\Widgets\Renderers\WidgetRenderer;

enum WidgetContentType: string
{
    case Widget = 'widget';
    case Livewire = 'livewire';
    case Feature = 'feature';
    case ContactForm = 'contact-form';
    case Reference = 'reference';
    case Article = 'article';
    case Page = 'page';
    case Place = 'place';
    case Album = 'album';

    public function renderer(): string
    {
        return match ($this) {
            self::Widget => WidgetRenderer::class,
            self::Livewire => LivewireRenderer::class,
            self::Feature => FeatureRenderer::class,
             self::ContactForm => ContactFormRenderer::class,
             self::Reference => ReferenceRenderer::class,
             self::Article => ArticleRenderer::class,
             self::Page => PageRenderer::class,
             self::Place => PlaceRenderer::class,
             self::Album => AlbumRenderer::class,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
