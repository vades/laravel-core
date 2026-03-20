<?php

namespace App\Services;

use App\Services\Cache\CacheService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\Project;

class DomainManagerService
{
    private const DEFAULT_SLUG = 'laravel-core';
    private const CACHE_KEY_PREFIX = 'project_id_map_';

    private const DEFAULT_PROJECT_ID = 0; // Fallback project ID if all else fails

    protected ?string $currentHost = null;
    protected string $slug = self::DEFAULT_SLUG;
    protected ?int $projectId = null;

    public function __construct(Request $request)
    {
        $this->initializeFromRequest($request);
    }

    /**
     * Initialize the service from the incoming request
     */
    private function initializeFromRequest(Request $request): void
    {
        $this->currentHost = $request->getHost();

        $this->slug = $this->determineSlug();
        $this->projectId = $this->resolveProjectId($this->slug);

        $this->updateApplicationConfig();
    }

    /**
     * Determine the appropriate slug from environment or host
     */
    private function determineSlug(): string
    {
        // Environment variable takes precedence
        $envSlug = env('MY_PROJECT_SLUG');
        if (!empty($envSlug)) {
            return $envSlug;
        }

        // Otherwise, detect from host
        return $this->detectSlugFromHost();
    }

    /**
     * Extract slug from the current host
     * Logic: ivnbg.com -> ivnbg, www.ivnbg.com -> ivnbg
     */
    private function detectSlugFromHost(): string
    {
        if ($this->isLocalOrEmptyHost()) {
            return self::DEFAULT_SLUG;
        }

        $normalizedHost = $this->normalizeHost($this->currentHost);

        return $this->extractSlugFromHost($normalizedHost);
    }

    /**
     * Check if running in CLI mode or localhost
     */
    private function isLocalOrEmptyHost(): bool
    {
        return empty($this->currentHost) || $this->currentHost === 'localhost';
    }

    /**
     * Normalize host by removing www prefix
     */
    private function normalizeHost(string $host): string
    {
        return Str::replace('www.', '', $host);
    }

    /**
     * Extract the slug from the host
     * Root domain: removes extension and prefixes (e.g., domain-name.com -> domain-name)
     * Subdomain: returns subdomain only (e.g., subdomain-name.domain.com -> subdomain-name)
     */
    private function extractSlugFromHost(string $host): string
    {
        if (empty($host)) {
            return self::DEFAULT_SLUG;
        }

        return explode('.', $host)[0];
    }

    /**
     * Resolve the project ID from the database using the slug
     */
    private function resolveProjectId(string $slug): ?int
    {
        $cacheKey = $this->getCacheKey($slug);
$cache = new CacheService();
        return $cache->remember(
            cacheName:   $cacheKey,
            callback:    fn() => $this->fetchProjectIdFromDatabase($slug) ,
            contentType: $slug,
        );
    }

    /**
     * Fetch project ID from the database
     */
    private function fetchProjectIdFromDatabase(string $slug): ?int
    {
        try {
            return Project::where('slug', $slug)->value('id');
        } catch (QueryException $e) {
            return null;
        }
    }

    /**
     * Generate cache key for a given slug
     */
    private function getCacheKey(string $slug): string
    {
        return self::CACHE_KEY_PREFIX . $slug;
    }

    /**
     * Update application configuration with the current slug
     */
    private function updateApplicationConfig(): void
    {
        Config::set('myapp.projectSlug', $this->slug);


        // Load project-specific config file
        $this->loadProjectConfig($this->slug);
    }

    private function loadProjectConfig(string $slug): void
    {
        $path = base_path("config/projects/{$slug}.php");

        if (!file_exists($path)) {
            return;
        }

        $projectConfig = require $path;

        // Merge project config into myapp config
        $current = Config::get('myapp', []);
        Config::set('myapp', array_replace_recursive($current, $projectConfig));
        \Log::debug("Loaded project config for slug: {$slug}", config('myapp'));
    }

    /**
     * Get the current slug
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Get the current project ID
     */
    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    /**
     * Manually set the slug (e.g., from an Artisan command)
     * This automatically re-resolves the project ID and updates config
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        $this->projectId = $this->resolveProjectId($slug);
        $this->updateApplicationConfig();

        return $this;
    }

    /**
     * Manually override the project ID if needed
     */
    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Clear the cached project ID for a specific slug
     */
    public function clearCache(?string $slug = null): void
    {
        $targetSlug = $slug ?? $this->slug;
        $cacheKey = $this->getCacheKey($targetSlug);

        Cache::forget($cacheKey);
    }

    /**
     * Refresh the project ID from the database
     */
    public function refresh(): self
    {
        $this->clearCache();
        $this->projectId = $this->resolveProjectId($this->slug);

        return $this;
    }
}