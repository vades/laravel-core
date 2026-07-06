<?php

namespace App\Enums;

enum ContentContentType: string
{
    case Article = 'article';
    case Page = 'page';
    case Meta = 'meta';
    case Place = 'place';
    case Tutorial = 'tutorial';

    case Guide= 'guide';
    case Aiprompt = 'aiprompt';

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