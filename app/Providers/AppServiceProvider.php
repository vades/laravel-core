<?php

namespace App\Providers;

use App\View\Composers\CategoryComposer;
use App\View\Composers\TagComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', CategoryComposer::class);
        View::composer('*', TagComposer::class);
    }
}