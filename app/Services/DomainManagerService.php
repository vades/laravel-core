<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\Project;

class DomainManagerService
{
    protected string $currentHost;
    protected string $slug;
    protected ?int $projectId = null;

    public function __construct(Request $request)
    {
        $this->currentHost = $request->getHost();
        $this->detectSlug();
        $this->resolveProjectId();
    }

    protected function detectSlug(): void
    {
        // 1. Remove www.
        $host = Str::replace('www.', '', $this->currentHost);

        // 2. Explode by dot and take the first part (ivnbg.com -> ivnbg)
        $parts = explode('.', $host);
        $this->slug = $parts[0] ?? 'default';
    }

    protected function resolveProjectId(): void
    {
        // Cache the lookup forever to avoid DB queries on every request.
        // Run 'php artisan cache:clear' if you manually change IDs in DB.
        $this->projectId = Cache::rememberForever("project_id_map_{$this->slug}", function () {
            return Project::where('slug', $this->slug)->value('id');
        });
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }
}
