# CacheService

`App\Services\CacheService`

A Laravel service for generating consistent, domain-scoped cache keys and interacting with the cache store. Keys are automatically namespaced to the current HTTP request host, ensuring entries never collide across multi-tenant or multi-domain applications.

---

## Installation

Place `CacheService.php` in `app/Services/Cache/` and `cacheDuration` in `config/myapp`.

Register the service as a singleton in `AppServiceProvider` (optional, but recommended to avoid repeated instantiation):

```php
// app/Providers/AppServiceProvider.php
public function register(): void
{
    $this->app->singleton(\App\Services\CacheService::class);
}
```

---

## Configuration

**`config/myapp.php`**

```php
return [
      'cacheDuration' => (int) env('MY_CACHE_DURATION', 86400),
];
```

Override the default TTL in your `.env` file:

```env
MY_CACHE_DURATION=3600  # 1 hour
```

If the config key is missing entirely, the service falls back to `86400` seconds (1 day).

---

## Cache Key Format

Every key follows this structure:

```
{domain}:{cacheName}:{hash}
```

| Segment | Description |
|---|---|
| `domain` | Normalized hostname from the current HTTP request (e.g. `example_com`) |
| `cacheName` | The name you provide, optionally suffixed with the normalized `contentType` |
| `hash` | 8-character MD5 hash of `domain:cacheName` — ensures uniqueness and prevents collisions |

**Examples:**

| `$cacheName` | `$contentType` | Host | Generated key |
|---|---|---|---|
| `products` | `null` | `example.com` | `example_com:products:a1b2c3d4` |
| `products` | `application/json` | `example.com` | `example_com:products_application_json:9f8e7d6c` |
| `categories` | `news` | `api.example.com` | `api_example_com:categories_news:3c2b1a0f` |

> **Note:** When running in CLI context (e.g. Artisan commands or queues), the domain segment falls back to `cli` since there is no active HTTP request.

---

## API Reference

### `generateCacheName()`

Generates a unique, deterministic cache key without storing anything.

```php
public function generateCacheName(string $cacheName, ?string $contentType = null): string
```

**Parameters**

| Name | Type | Required | Description |
|---|---|---|---|
| `$cacheName` | `string` | Yes | Logical name for the cache entry |
| `$contentType` | `string\|null` | No | Optional content type appended to the name (e.g. `application/json`, `text/html`) |

**Returns** `string` — the full cache key.

```php
$key = $this->cache->generateCacheName('products');
// → "example_com:products:a1b2c3d4"

$key = $this->cache->generateCacheName('products', 'application/json');
// → "example_com:products_application_json:9f8e7d6c"
```

---

### `put()`

Stores a value in the cache and returns the key used.

```php
public function put(
    string $cacheName,
    mixed $value,
    ?string $contentType = null,
    ?int $duration = null
): string
```

**Parameters**

| Name | Type | Required | Description |
|---|---|---|---|
| `$cacheName` | `string` | Yes | Logical name for the cache entry |
| `$value` | `mixed` | Yes | The value to store |
| `$contentType` | `string\|null` | No | Optional content type |
| `$duration` | `int\|null` | No | TTL in seconds. Defaults to `config('cache_service.default_duration')` |

**Returns** `string` — the cache key that was used.

```php
$key = $this->cache->put('products', $products);
$key = $this->cache->put('products', $products, 'application/json');
$key = $this->cache->put('products', $products, 'application/json', 3600);
```

---

### `get()`

Retrieves a cached value by name and optional content type.

```php
public function get(string $cacheName, ?string $contentType = null, mixed $default = null): mixed
```

**Parameters**

| Name | Type | Required | Description |
|---|---|---|---|
| `$cacheName` | `string` | Yes | Logical name of the cache entry |
| `$contentType` | `string\|null` | No | Must match what was used when storing |
| `$default` | `mixed` | No | Returned on a cache miss. Defaults to `null` |

**Returns** `mixed` — the cached value, or `$default` on miss.

```php
$products = $this->cache->get('products');
$products = $this->cache->get('products', 'application/json');
$products = $this->cache->get('products', null, []);
```

---

### `getByName()`

Retrieves a cached value directly by a previously generated key string. Useful when the key was stored externally or returned by `put()`.

```php
public function getByName(string $cacheName, mixed $default = null): mixed
```

**Parameters**

| Name | Type | Required | Description |
|---|---|---|---|
| `$cacheName` | `string` | Yes | A full key string as returned by `generateCacheName()` or `put()` |
| `$default` | `mixed` | No | Returned on a cache miss. Defaults to `null` |

**Returns** `mixed` — the cached value, or `$default` on miss.

```php
$key      = $this->cache->put('products', $products);
$products = $this->cache->getByName($key);
```

---

### `has()`

Checks whether a cache entry exists for the given name and content type.

```php
public function has(string $cacheName, ?string $contentType = null): bool
```

**Returns** `bool`

```php
if ($this->cache->has('products')) { ... }
if ($this->cache->has('products', 'application/json')) { ... }
```

---

### `forget()`

Removes a specific cache entry.

```php
public function forget(string $cacheName, ?string $contentType = null): bool
```

**Returns** `bool` — `true` on success.

```php
$this->cache->forget('products');
$this->cache->forget('products', 'application/json');
```

---

### `remember()`

Returns the cached value if it exists, otherwise executes the callback, stores the result, and returns it. This is the primary method for most use cases.

```php
public function remember(
    string $cacheName,
    \Closure $callback,
    ?string $contentType = null,
    ?int $duration = null
): mixed
```

**Parameters**

| Name | Type | Required | Description |
|---|---|---|---|
| `$cacheName` | `string` | Yes | Logical name for the cache entry |
| `$callback` | `Closure` | Yes | Executed on cache miss; its return value is stored and returned |
| `$contentType` | `string\|null` | No | Optional content type |
| `$duration` | `int\|null` | No | TTL in seconds. Defaults to `config('cache_service.default_duration')` |

**Returns** `mixed` — the cached or freshly computed value.

```php
$products = $this->cache->remember(
    cacheName: 'products',
    callback:  fn() => Product::published()->get(),
);

// With content type
$products = $this->cache->remember(
    cacheName:   'products',
    callback:    fn() => Product::published()->get(),
    contentType: 'application/json',
);

// With custom TTL
$products = $this->cache->remember(
    cacheName: 'products',
    callback:  fn() => Product::published()->get(),
    duration:  3600,
);
```

---

## Usage Examples

### Dependency Injection

```php
use App\Services\CacheService;

class ProductController extends Controller
{
    public function __construct(private CacheService $cache) {}

    public function index()
    {
        $products = $this->cache->remember(
            cacheName: 'products',
            callback:  fn() => Product::published()->get(),
        );

        return view('products.index', compact('products'));
    }
}
```

### View Composer

```php
class CategoryComposer
{
    public function __construct(private CacheService $cache) {}

    public function compose(View $view): void
    {
        $categoryType = $view->getData()['categoryType'] ?? '';

        $categories = $this->cache->remember(
            cacheName:   'categories',
            callback:    fn() => Category::publishedByType($categoryType)
                                         ->withCount('contents')
                                         ->where('contents_count', '>', 0)
                                         ->get(),
            contentType: $categoryType ?: null,
        );

        $view->with([
            'composerCategories'      => $categories,
            'composerCurrentCategory' => request()->query('category'),
        ]);
    }
}
```

### Manual Store and Retrieve

```php
// Store and capture the key
$key = $this->cache->put('settings', $settings, 'application/json', 7200);

// Retrieve later by key string
$settings = $this->cache->getByName($key);
```

### Cache Invalidation

```php
// Forget a specific variant
$this->cache->forget('products', 'application/json');

// Forget without content type
$this->cache->forget('products');
```

---

## Private Methods

These are internal to the service and not part of the public API.

### `defaultDuration()`

Reads `config('cache_service.default_duration')` and returns it as an `int`. Falls back to `86400` if the config key is absent.

### `normalizeDomain()`

Reads the hostname from `Request::getHost()`, lowercases it, and replaces all non-alphanumeric characters with underscores. Falls back to `'cli'` outside HTTP context.

| Input | Output |
|---|---|
| `example.com` | `example_com` |
| `api.example.com` | `api_example_com` |
| `localhost:8000` | `localhost_8000` |
| _(Artisan / queue)_ | `cli` |