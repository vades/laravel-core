<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait FilterByLang
{
    protected static function bootFilterByLang(): void
    {
        static::addGlobalScope('lang_scope', function (Builder $builder) {
            $lang = App::getLocale() ?: 'en';

            $builder->where('lang', $lang);
        });
    }
}
