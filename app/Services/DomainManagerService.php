<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\Project;
use Illuminate\Support\Facades\Config;

class DomainManagerService
{
    protected ?string $currentHost = null;
    protected string $slug = 'default';
    protected ?int $projectId = null;

    public function __construct(Request $request)
    {
        // In CLI mode, getHost() might return 'localhost' or an empty string.
        $this->currentHost = $request->getHost();

        // Initial detection
        $this->detectSlug();
        $this->resolveProjectId();
        Config::set('myapp.projectSlug', $this->getSlug());
    }

    /**
     * Manually set the slug (e.g., from an Artisan command argument).
     * This will automatically re-resolve the project ID.
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        $this->resolveProjectId();

        return $this;
    }

    /**
     * Detect slug from host.
     * Logic: ivnbg.com -> ivnbg, www.ivnbg.com -> ivnbg
     */
    protected function detectSlug(): void
    {
        if (empty($this->currentHost) || $this->currentHost === 'localhost') {
            return;
        }

        $host = Str::replace('www.', '', $this->currentHost);
        $parts = explode('.', $host);
        $this->slug = $parts[0] ?? 'default';
    }

    /**
     * Resolve the project ID based on the current slug.
     */
    protected function resolveProjectId(): void
    {
        // We use the slug as the cache key.
        $this->projectId = Cache::rememberForever("project_id_map_{$this->slug}", function () {
            return Project::where('slug', $this->slug)->value('id');
        });
    }

    public function getSlug(): string
    {
        $envSlug = env('MY_PROJECT_SLUG');
        if (!empty($envSlug)) {
            return $envSlug;
        }
        return $this->slug;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    /**
     * Allows manual override of the Project ID if needed.
     */
    public function setProjectId(int $projectId): self
    {
        $this->projectId = $projectId;
        return $this;
    }
}