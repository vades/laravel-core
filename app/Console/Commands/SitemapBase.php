<?php

namespace App\Console\Commands;

use App\Enums\AppProject;
use App\Enums\ContentContentType;
use App\Models\Category;
use App\Models\Content;
use App\Services\DomainManagerService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\Console\Helper\ProgressBar;
use Throwable;

abstract class SitemapBase extends Command
{

    private Sitemap $sitemap;
    private ProgressBar $bar;
    private string $baseUrl;
    private int $projectId;

    public function __construct(protected DomainManagerService $domainManager)
    {
        parent::__construct();
    }


    // ── Setup ────────────────────────────────────────────────────────────────

    protected function bootstrap(string $project): void
    {
        $appProject = AppProject::from($project);

        $this->baseUrl = $appProject->getUrl();
        $this->domainManager->setSlug($appProject->value);
        $this->projectId = $this->domainManager->getProjectId();

        config(['app.project_id' => $this->projectId]);

        $this->sitemap = Sitemap::create();
    }

    protected function initProgressBar(Collection ...$collections): void
    {
        $staticCount = 3; // home + about + contact
        $total = $staticCount + array_sum(array_map(fn(Collection $c) => $c->count(), $collections));

        $this->bar = $this->output->createProgressBar($total);
        $this->bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% — %message%');
        $this->bar->setMessage('Initialising...');
        $this->bar->start();
    }

    protected function fetchContents(ContentContentType $contentType): Collection
    {
        return Content::withoutGlobalScopes()
                      ->where('project_id', $this->projectId)
                      ->publishedByType($contentType)
                      ->get();
    }

    protected function addContents(Collection $contents, string $routeName = null): void
    {
        foreach ($contents as $content) {
            $urlPath = $routeName ? "{$routeName}/{$content->slug}" : $content->slug;
            $this->bar->setMessage("Adding content: {$urlPath}");
            $this->sitemap->add(
                Url::create("{$this->baseUrl}/{$urlPath}")
                   ->setLastModificationDate(Carbon::yesterday())
            );
            $this->bar->advance();
        }
    }

    protected function writeSitemap(string $publicPath = null): void
    {
        $path = $publicPath ?? public_path('sitemap.xml');

        if ($publicPath) {
            $path = rtrim($publicPath, '/') . '/sitemap.xml';
        }

        $this->bar->setMessage("Writing sitemap.xml to {$path}...");
        $this->sitemap->writeToFile($path);
        $this->bar->finish();
    }

    // ── Output helpers ───────────────────────────────────────────────────────

    protected function logFetchedCounts(Collection ...$collections): void
    {
        $parts = array_map(
            fn(Collection $collection, string $label) => "<comment>{$collection->count()}</comment> {$label}",
            $collections,
            array_keys($collections)
        );

        $this->line('  Found ' . implode(' and ', $parts) . '.');
        $this->newLine();
    }

    protected function logFetchedCountsOld(Collection $categories, Collection $articles): void
    {
        $this->line("  Found <comment>{$categories->count()}</comment> categories and <comment>{$articles->count()}</comment> articles.");
        $this->newLine();
    }

    protected function printSuccessSummary(Collection ...$collections): void
    {
        $total = 3 + array_sum(array_map(fn(Collection $c) => $c->count(), $collections));

        $this->newLine(2);
        $this->info('✅  Sitemap generated successfully → <comment>public/sitemap.xml</comment>');
        $this->line("    Total URLs written: <comment>{$total}</comment>");
        $this->newLine();

        logger()->info('Sitemap generated successfully', [
            'total_urls' => $total
        ]);
    }

    protected function printError(Throwable $e): void
    {
        $this->newLine(2);
        $this->error('❌  Sitemap generation failed!');
        $this->newLine();
        $this->line("    <fg=red>Error:</> {$e->getMessage()}");
        $this->line("    <fg=red>File:</>  {$e->getFile()} (line {$e->getLine()})");
        $this->newLine();

        logger()->error('Sitemap generation failed', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
           // 'trace'   => $e->getTraceAsString(),
        ]);
    }
}