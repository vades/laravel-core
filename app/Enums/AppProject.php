<?php

namespace App\Enums;

enum AppProject: string
{
    case Ivnbg = 'ivnbg';
    case MartinVach = 'martinvach';
    case MyPrompties = 'myprompties';
    case Vades = 'vades';
    case Aitomatix = 'aitomatix';
    case AitomatixCz = 'aitomatix-cz';
    case LaravelCore = 'laravel-core';

    /**
     * Get the project URL by enum case.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return match ($this) {
            self::Ivnbg => 'https://www.ivnbg.com',
            self::MartinVach => 'https://www.martinvach.com',
            self::MyPrompties => 'https://www.myprompties.com',
            self::Vades => 'https://www.vades.dev',
            self::Aitomatix => 'https://www.aitomatix.com',
            self::AitomatixCz => 'https://www.aitomatix.cz',
            self::LaravelCore => 'http://laravel-core.test',
        };
    }
}