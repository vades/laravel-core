<?php

namespace App\Enums;

enum AppProject: string
{
    case Ivnbg = 'ivnbg-com';
    case MartinVach = 'martinvach-com';
    case MyPrompties = 'myprompties-com';
    case Vades = 'vades-dev';
    case Aitomatix = 'aitomatix-com';
    case AitomatixCz = 'aitomatix-cz';
    case LaravelCore = 'laravel-core-test';
    case LaravelCoreVades = 'laravel-core-vades-dev';

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
            self::LaravelCoreVades => 'https://www.laravel-core.vades.dev',
        };
    }
}