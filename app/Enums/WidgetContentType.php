<?php

namespace App\Enums;

enum WidgetContentType: string
{
    case Widget = 'widget';
    case Livewire = 'liveware';
    case Feature = 'feature';

    /**
     * Get all enum values as array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all enum names as array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}