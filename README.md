# Laravel Multi-Domain CMS

A Laravel application for serving and managing several project websites from one codebase. Each request is associated with a project (tenant) based on its host, and the project's content and presentation are selected accordingly.

## What the application does

- Serves public pages, articles, places, services, references, tags, and photo galleries.
- Stores project content, categories, tags, inquiries, widgets, and related data in a shared database.
- Renders Markdown content and database-backed widgets/shortcodes.
- Imports project content from Markdown files with YAML front matter.
- Generates photo-album data and project sitemaps.
- The Filament panel provider is currently commented out in `bootstrap/providers.php`; and it is moved to standalone project.

## Multi-domain and multi-tenant design

This is a **single-database, multi-tenant application**: all domains use the same configured database connection. A `projects` row represents each tenant, and tenant-owned records are associated through `project_id`; the application does not create a separate database per domain.

`DomainManagerService` selects a project slug in this order:

1. A non-empty `MY_PROJECT_SLUG` configuration value overrides host detection.
2. Otherwise, the request host is matched to `AppProject` in `app/Enums/AppProject.php`. A leading `www.` is ignored, but domain extensions are significant.
3. If the host is not mapped, the service uses the `laravel-core` default.

Examples:

| Host                                  | Project slug   |
| ------------------------------------- | -------------- |
| `aitomatix.com` / `www.aitomatix.com` | `aitomatix`    |
| `aitomatix.cz` / `www.aitomatix.cz`   | `aitomatix-cz` |
| `vades.dev` / `www.vades.dev`         | `vades`        |
| `laravel-core.test`                   | `laravel-core` |

For host-based local development, leave `MY_PROJECT_SLUG` empty and use a local hostname mapped to a project in `AppProject`. Set it explicitly when you need to force a tenant regardless of the host.

The `FilterByProject` trait applies a project scope and assigns the active project ID when creating records. It is used by core tenant data models including content, categories, tags, widgets, and inquiries. Apply equivalent project filtering to any new tenant-owned models and queries; do not assume every model is automatically scoped.

The request's slug also selects optional project configuration (`config/projects/{slug}.php`), routes (`routes/{slug}.php`, with `routes/default.php` as fallback), views (`resources/views/components/{slug}`, with shared defaults), and CSS (`resources/css/{slug}/app.css`, with a default fallback).

### Adding a project

1. Add an `AppProject` enum case and its canonical URL.
2. Add a matching project record to `database/seeders/ProjectSeeder.php` so the tenant has a database ID.
3. Add optional `config/projects/{slug}.php`, `routes/{slug}.php`, tenant-specific views, and CSS as needed.
4. Ensure the domain resolves to the new host and leave `MY_PROJECT_SLUG` empty when testing host-based selection.

**Fresh-database note:** `AppProject` currently includes `aitomatix-cz`, but `ProjectSeeder` does not yet seed that project. Add its project record before expecting project-scoped data to work for that tenant on a newly seeded database.

## Developer setup

### Requirements

- PHP 8.4
- Composer
- Node.js and npm
- A database supported by Laravel; SQLite is the default in `.env.example`

### Install

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure the database connection in `.env` before migrating. Set `MY_PROJECT_SLUG` only if you want to override host-based detection. The values in `config/myapp.php` also support project import, image storage, album generation, and seeded-user configuration.

The Composer setup script runs migrations and builds frontend assets:

```bash
composer run setup
```

It does not seed the database. To add the project records and local sample data, configure the `MY_USER_NAME`, `MY_USER_EMAIL`, and `MY_USER_PASSWORD` values used by `UserSeeder`, then run:

```bash
php artisan db:seed
```

`DatabaseSeeder` adds sample content when `APP_ENV=local`. The `composer run init-dev` script is for a disposable development database only: it runs `migrate:fresh` and therefore drops existing tables and data.

### Run locally

```bash
composer run dev
```

This starts the Laravel development server, a queue listener, and the Vite development server. To run these separately, use `php artisan serve`, `php artisan queue:listen --tries=1`, and `npm run dev`.

Build frontend assets for production with:

```bash
npm run build
```

### Useful commands

```bash
php artisan test --compact
vendor/bin/pint --dirty
php artisan app:import-project-content
php artisan app:generate-album --url=https://example.com/
php artisan app:generate-sitemap aitomatix
```

Project content imports are read from `storage/app/imports/projects/{slug}/content/`. The directory structure supports content-type folders and optional category subfolders. See the import service for accepted Markdown front matter and data fields.

For production, create the public storage link with `php artisan storage:link` and configure Laravel's scheduler to invoke `php artisan schedule:run` each hour. Scheduled album, import, and sitemap tasks are defined in `routes/console.php`.

## Main code areas

| Path                                    | Purpose                                                            |
| --------------------------------------- | ------------------------------------------------------------------ |
| `app/Enums/AppProject.php`              | Project slugs, canonical URLs, and host mapping                    |
| `app/Services/DomainManagerService.php` | Resolves the active project and project ID                         |
| `app/Traits/FilterByProject.php`        | Project-scoped queries and project assignment                      |
| `app/Models/`                           | Projects, content, users, categories, tags, widgets, and inquiries |
| `app/Http/Controllers/Web/Default/`     | Public website controllers                                         |
| `app/Services/Content/`                 | Markdown rendering and shortcode parsing                           |
| `app/Services/Import/`                  | Markdown content import                                            |
| `app/Services/Widgets/`                 | Database-backed widget rendering                                   |
| `app/Filament/Resources/`               | Filament resource definitions                                      |
| `routes/`                               | Shared and project-specific route definitions                      |
| `resources/views/components/`           | Shared and project-specific Blade components                       |
| `config/projects/`                      | Optional per-project application settings                          |

## Documentation

- [DomainManagerService](docs/DomainManagerService.md)
- [CacheService](docs/CacheService.md)
- [Widget](docs/Widget.md)
- [ShortCode](docs/ShortCode.md)
- [Carousel](docs/Carousel.md)
