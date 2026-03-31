<?php

namespace App\Console\Commands;

use App\Enums\ContentContentType;
use Throwable;

class GenerateSitemap extends SitemapBase
{
    protected $signature = 'app:generate-sitemap {project : The project slug (e.g. laravel-core)} {--path= : Optional custom public path for the sitemap}';
    protected $description = 'Generate sitemap for a given project';

    public function handle(): int
    {
        $project = $this->argument('project');

        $this->info("🗺  Starting sitemap generation for {$project}...");
        $this->newLine();

        try {
            $this->bootstrap($project);

            $pages     = $this->fetchContents(ContentContentType::Page);
            $metaPages = $this->fetchContents(ContentContentType::Meta);
            $articles  = $this->fetchContents(ContentContentType::Article);
            $places    = $this->fetchContents(ContentContentType::Place);
            $tutorials = $this->fetchContents(ContentContentType::Tutorial);
            $guides    = $this->fetchContents(ContentContentType::Guide);
            $aiprompts = $this->fetchContents(ContentContentType::Aiprompt);

            $this->logFetchedCounts(articles: $articles, pages: $pages, metaPages: $metaPages, places: $places,
                                    tutorials: $tutorials, guides: $guides, aiprompts: $aiprompts);
            $this->initProgressBar(articles: $articles, pages: $pages, metaPages: $metaPages, places: $places,
                                   tutorials: $tutorials, guides: $guides, aiprompts: $aiprompts);

            $this->addContents($pages, 'pages');
            $this->addContents($metaPages);
            $this->addContents($articles, 'blog');
            $this->addContents($places, 'place');
            $this->addContents($tutorials, 'tutorial');
            $this->addContents($guides, 'guide');
            $this->addContents($aiprompts, 'aiprompt');

            $this->writeSitemap($this->option('path'));
            $this->printSuccessSummary(articles: $articles, pages: $pages, metaPages: $metaPages, places: $places,
                                       tutorials: $tutorials, guides: $guides, aiprompts: $aiprompts);

            return self::SUCCESS;

        } catch (Throwable $e) {
            $this->printError($e);
            report($e);

            return self::FAILURE;
        }
    }
}