# DomainManagerService

`App\Services\DomainManagerService`

Resolves the active project slug from application configuration or the incoming request host. It then resolves the corresponding project ID and updates the application's project-specific configuration. The service is registered as a singleton by `MultiDomainServiceProvider`.

---

## Slug Resolution

Slug selection follows this order:

1. Use a non-empty string from `config('myapp.projectSlug')`. This value is configured from `MY_PROJECT_SLUG` in `config/myapp.php` and takes precedence over the request host.
2. Match the request host against the project URLs in `App\Enums\AppProject`. Matching is case-insensitive, and a leading `www.` is ignored.
3. Use `laravel-core` when the host is empty or does not match a project.

The host-to-slug mapping is maintained by `AppProject`; the domain extension is not stripped to infer a slug.

| Host | Slug |
|---|---|
| `ivnbg.com` or `www.ivnbg.com` | `ivnbg` |
| `martinvach.com` or `www.martinvach.com` | `martinvach` |
| `myprompties.com` or `www.myprompties.com` | `myprompties` |
| `vades.dev` or `www.vades.dev` | `vades` |
| `aitomatix.com` or `www.aitomatix.com` | `aitomatix` |
| `aitomatix.cz` or `www.aitomatix.cz` | `aitomatix-cz` |
| `laravel-core.test` | `laravel-core` |

Set an explicit project slug in `.env` when host-based selection should be overridden:

```env
MY_PROJECT_SLUG=aitomatix-cz
```

The configured slug is used as provided; it is not validated against `AppProject`.

---

## Initialization

The service receives an `Illuminate\Http\Request` and initializes these values:

- The request host.
- The selected project slug.
- The project ID queried by that slug.
- `myapp.projectSlug` and any project-specific configuration.

Project configuration is loaded from `config/projects/{slug}.php` when that file exists, then recursively merged into the existing `myapp` configuration. A missing project config file is ignored.

Project ID lookup queries `projects.slug` and caches the result through `CacheService`. A database `QueryException` during lookup returns `null`; it does not prevent slug selection.

---

## Public API

### `getSlug()`

```php
public function getSlug(): string
```

Returns the active project slug.

### `getProjectId()`

```php
public function getProjectId(): ?int
```

Returns the resolved project ID, or `null` if it could not be resolved.

### `setSlug()`

```php
public function setSlug(string $slug): self
```

Manually replaces the active slug, resolves its project ID, updates `myapp.projectSlug`, and loads the matching project configuration if present. The slug is not validated against `AppProject`.

```php
$domainManager->setSlug('aitomatix-cz');
```

### `setProjectId()`

```php
public function setProjectId(int $projectId): self
```

Manually overrides the project ID without changing the slug.

### `clearCache()`

```php
public function clearCache(?string $slug = null): void
```

Attempts to remove the cached project ID for the supplied slug, or for the current slug when omitted.

> **Implementation note:** Project ID lookups are stored using `CacheService`'s generated, domain-scoped key. `clearCache()` currently calls `Cache::forget()` with the raw `project_id_map_{slug}` key, so it may not remove the lookup entry created by `resolveProjectId()`.

### `refresh()`

```php
public function refresh(): self
```

Calls `clearCache()` for the current slug and resolves the project ID again. Because of the cache-key difference noted above, this may return a cached ID rather than force a fresh database lookup.
