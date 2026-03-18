<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class CacheService
{
    /**
     * Generate a unique, deterministic cache key from the current request host,
     * a required cache name, and an optional content type.
     *
     * Format: {domain}:{cacheName}:{hash}
     * Example (no type):   example_com:products:a1b2c3d4
     * Example (with type): example_com:products_application_json:a1b2c3d4
     */
    public function generateCacheName(string $cacheName, ?string $contentType = null): string
    {
        $normalizedDomain = $this->normalizeDomain();

        if (!empty($contentType)) {
            $normalizedType = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $contentType));
            $cacheName .= '_' . trim($normalizedType, '_');
        }

        $hash = substr(md5($normalizedDomain . ':' . $cacheName), 0, 8);

        return "{$normalizedDomain}:{$cacheName}:{$hash}";
    }

    /**
     * Store a value in the cache under the generated key.
     *
     * @param  string       $cacheName
     * @param  mixed        $value        Data to cache
     * @param  string|null  $contentType
     * @param  int|null     $duration     TTL in seconds (null = config default)
     * @return string                     The cache key that was used
     */
    public function put(
        string $cacheName,
        mixed $value,
        ?string $contentType = null,
        ?int $duration = null
    ): string {
        $key = $this->generateCacheName($cacheName, $contentType);

        Cache::put($key, $value, $duration ?? $this->defaultDuration());

        return $key;
    }

    /**
     * Retrieve a cached value by cache name and optional content type.
     *
     * @param  string       $cacheName
     * @param  string|null  $contentType
     * @param  mixed        $default     Returned when the key is not found
     * @return mixed
     */
    public function get(string $cacheName, ?string $contentType = null, mixed $default = null): mixed
    {
        $key = $this->generateCacheName($cacheName, $contentType);

        return Cache::get($key, $default);
    }

    /**
     * Retrieve a cached value directly by its cache key name.
     *
     * @param  string  $cacheName   Key previously returned by generateCacheName() or put()
     * @param  mixed   $default
     * @return mixed
     */
    public function getByName(string $cacheName, mixed $default = null): mixed
    {
        return Cache::get($cacheName, $default);
    }

    /**
     * Check whether a cache entry exists.
     */
    public function has(string $cacheName, ?string $contentType = null): bool
    {
        return Cache::has($this->generateCacheName($cacheName, $contentType));
    }

    /**
     * Remove a specific cache entry.
     */
    public function forget(string $cacheName, ?string $contentType = null): bool
    {
        return Cache::forget($this->generateCacheName($cacheName, $contentType));
    }

    /**
     * Retrieve from cache or execute the callback and store the result.
     *
     * @param  string       $cacheName
     * @param  \Closure     $callback    Produces the value when cache misses
     * @param  string|null  $contentType
     * @param  int|null     $duration    TTL in seconds (null = config default)
     * @return mixed
     */
    public function remember(
        string $cacheName,
        \Closure $callback,
        ?string $contentType = null,
        ?int $duration = null
    ): mixed {
        $key = $this->generateCacheName($cacheName, $contentType);

        return Cache::remember($key, $duration ?? $this->defaultDuration(), $callback);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve the default TTL from config/cache_service.php.
     * Falls back to 86400 (1 day) if the config key is missing.
     */
    private function defaultDuration(): int
    {
        return (int) config('myapp.cacheDuration', 86400);
    }

    /**
     * Resolve and normalize the domain from the current HTTP request host.
     * Falls back to 'cli' when running outside of an HTTP context (e.g. Artisan).
     *
     * Examples:
     *   "example.com"      → "example_com"
     *   "api.example.com"  → "api_example_com"
     *   "localhost:8000"   → "localhost_8000"
     */
    private function normalizeDomain(): string
    {
        $host = Request::getHost() ?: 'cli';

        $host = strtolower($host);
        $host = preg_replace('/[^a-z0-9]+/', '_', $host);

        return trim($host, '_');
    }
}