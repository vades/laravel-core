<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use App\Services\DomainManagerService;

class MultiDomainServiceProvider extends ServiceProvider
{
    private string $slug;
    private string $siteViewPath;
    private string $defaultViewPath;

    public function register(): void
    {
        $this->registerDomainManagerService();
    }

    public function boot(DomainManagerService $domainManager): void
    {
        $this->initializePaths($domainManager);

        $this->configureViewCascade();
        $this->configureViteBuildDirectory();
        $this->shareGlobalCssPath();
        //$this->shareGlobalNavigation();

        // Routing is disabled due to double-loading issues
        // $this->configureRouting();
    }

    /**
     * Register the DomainManagerService as a singleton
     */
    private function registerDomainManagerService(): void
    {
        $this->app->singleton(DomainManagerService::class, function ($app) {
            return new DomainManagerService($app->request);
        });
    }

    /**
     * Initialize common paths used throughout the provider
     */
    private function initializePaths(DomainManagerService $domainManager): void
    {
        $this->slug = $domainManager->getSlug();
        $this->siteViewPath = resource_path("views/components/{$this->slug}");
        $this->defaultViewPath = resource_path("views/components/default");
    }

    /**
     * Configure view cascade: site-specific → default → standard resources/views
     */
    private function configureViewCascade(): void
    {
        // Add site-specific views first (highest priority)
        if (is_dir($this->siteViewPath)) {
            View::share('globalViewPath', $this->siteViewPath);
            View::getFinder()->prependLocation($this->siteViewPath);
        }

        // Add default views as fallback
        if (is_dir($this->defaultViewPath)) {
            View::share('globalViewPath', $this->defaultViewPath);
            View::getFinder()->addLocation($this->defaultViewPath);
        }
    }

    /**
     * Configure Vite to use the appropriate build directory
     */
    private function configureViteBuildDirectory(): void
    {
        Vite::useBuildDirectory('build');
    }

    /**
     * Share the appropriate CSS path with all views
     */
    private function shareGlobalCssPath(): void
    {
        $cssPath = $this->resolveCssPath();
        View::share('globalCssPath', $cssPath);
    }

    /**
     * Determine which CSS file to use (site-specific or default)
     */
    private function resolveCssPath(): string
    {
        $customCssPath = "resources/css/{$this->slug}/app.css";
        $defaultCssPath = "resources/css/default/app.css";

        return file_exists(resource_path("css/{$this->slug}/app.css"))
            ? $customCssPath
            : $defaultCssPath;
    }

    /**
     * TODO: deprecated
     * Share navigation data with all views
     */
    private function shareGlobalNavigation(): void
    {
        $navigation = $this->loadNavigationData();
        View::share('globalNav', $navigation);
    }

    /**
     * TODO: deprecated
     * Load navigation data from site-specific or default location
     */
    private function loadNavigationData(): array
    {
        $siteNavPath = $this->siteViewPath . '/data/nav.php';
        $defaultNavPath = $this->defaultViewPath . '/data/nav.php';

        $navPath = file_exists($siteNavPath) ? $siteNavPath : $defaultNavPath;

        return require_once $navPath;
    }

    /**
     * Configure domain-specific routing
     *
     * TODO: Currently disabled - routes are loaded twice causing conflicts
     * Need to implement proper route caching or registration guard
     */
    private function configureRouting(): void
    {
        // Prevent double-loading of routes
        if (!app()->has('routes_loaded_by_multidomain')) {
            $this->registerRoutes();
            app()->instance('routes_loaded_by_multidomain', true);
        }
    }

    /**
     * Register routes from domain-specific file or fallback to web.php
     */
    private function registerRoutes(): void
    {
        $routeFile = base_path("routes/{$this->slug}.php");

        if (file_exists($routeFile)) {
            ds("Loading domain route file: {$routeFile}");
            Route::middleware('web')->group($routeFile);
        } else {
            ds("Loading fallback route file: routes/web.php");
            Route::middleware('web')->group(base_path('routes/web.php'));
        }
    }
}