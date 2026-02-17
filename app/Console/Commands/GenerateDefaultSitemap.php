<?php

namespace App\Console\Commands;

use App\Enums\AppProject;
use App\Enums\ContentContentType;
use App\Models\Category;
use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Services\DomainManagerService;

class GenerateDefaultSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-default-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate laravel-core.test sitemap';

    public function __construct(protected DomainManagerService $domainManager)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $baseUrl =AppProject::LaravelCore->getUrl();
        $this->domainManager->setSlug(AppProject::LaravelCore->value);
        $projectId = $this->domainManager->getProjectId();
        config(['app.project_id' => $projectId]);
        Log:info('Generating martinvach.com sitemap...');

        // Manually create sitemap
        $sitemap = Sitemap::create();
        // Home page
        $sitemap->add(Url::create($baseUrl)->setLastModificationDate(Carbon::yesterday()));

        // Static pages
        $sitemap->add(Url::create("{$baseUrl}/pages/about")->setLastModificationDate(Carbon::yesterday()));
        $sitemap->add(Url::create("{$baseUrl}/pages/contact")->setLastModificationDate(Carbon::yesterday()));

        // Dynamic pages
        $categories = Category::withoutGlobalScopes()->where('project_id', $projectId)->publishedByType
        (ContentContentType::Article)->get();

        foreach ($categories as $category) {
            $sitemap->add(Url::create("{$baseUrl}/blog?category={$category->slug}")->setLastModificationDate(Carbon::yesterday()));
        }
        $articles = Content::withoutGlobalScopes()->where('project_id', $projectId)->publishedByType
            (ContentContentType::Article)->get();
        foreach ($articles as $item) {
            $sitemap->add(Url::create("{$baseUrl}/blog/{$item->slug}")->setLastModificationDate(Carbon::yesterday()));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}