<?php

namespace App\Enums;

enum Language: string
{
    case EN = 'en';
    case ES = 'es';
    case FR = 'fr';
    case DE = 'de';
    case CS = 'cs';

    public function label(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::ES => 'Spanish',
            self::FR => 'French',
            self::DE => 'German',
            self::CS => 'Czech',
        };
    }
}
