<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use App\Services\DomainManagerService;

class MultiDomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DomainManagerService::class, function ($app) {
            return new DomainManagerService($app->request);
        });
    }

    public function boot(DomainManagerService $domainManager): void
    {
        $slug = $domainManager->getSlug();

        // 1. View System Cascade
        // Look in sites/{slug} first, then default/, then standard resources/views
        $siteViewPath = resource_path("views/components/{$slug}");
        $defaultViewPath = resource_path("views/components/default");


        if (is_dir($siteViewPath)) {
            View::share('globalViewPath',$siteViewPath);
            View::getFinder()->prependLocation($siteViewPath);
        }
        if (is_dir($defaultViewPath)) {
            View::share('globalViewPath',$defaultViewPath);
            View::getFinder()->addLocation($defaultViewPath);
        }

        // 2. Vite Build Directory
        // Assets are served from the domain's specific build folder
        Vite::useBuildDirectory('build');


        $customCssPath = "resources/css/{$slug}/app.css";
        $defaultCssPath = "resources/css/default/app.css";

        // We check against the absolute path to see if the file exists
        $cssToLoad = file_exists(resource_path("css/{$slug}/app.css"))
            ? $customCssPath
            : $defaultCssPath;

        // 2. Share it globally with all views
        View::share('globalCssPath', $cssToLoad);

        $defaultNav = $defaultViewPath . '/data/nav.php';
        $siteNav = $siteViewPath . '/data/nav.php';

        $globalNav = file_exists($siteNav)
            ? require_once $siteNav
            : require_once  $defaultNav;

        View::share('globalNav', $globalNav);


        // 3. Routing
        // Prevent double-loading of routes
        /*if (!app()->has('routes_loaded_by_multidomain')) {
            $this->registerRoutes($slug);
            app()->instance('routes_loaded_by_multidomain', true);
        }*/
    }
    //TODO: Does not work as expected, routes are loaded twice causing route conflicts
    protected function registerRoutes(string $slug): void
    {
        $routeFile = base_path("routes/{$slug}.php");

        if (file_exists($routeFile)) {
            ds("Loading domain route file: {$routeFile}");
            Route::middleware('web')->group($routeFile);
        } else {
            ds("Loading fallback route file: routes/web.php");
            Route::middleware('web')->group(base_path('routes/web.php'));
        }
    }
}