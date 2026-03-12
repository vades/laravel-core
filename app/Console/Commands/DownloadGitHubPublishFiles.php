<?php

namespace App\Console\Commands;

use App\Services\GitHub\DownloadPublishFiles;
use Illuminate\Console\Command;

class DownloadGitHubPublishFiles extends Command
{
    protected $signature   = 'github:download-publish-files {--dry-run : List files without downloading}';
    protected $description = 'Download all files from vades/publishing into storage/app/imports';

    public function handle(): int
    {
        $this->info('Fetching file list from GitHub…');

        try {
            $paths = DownloadPublishFiles::getFileList();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->line(sprintf('Found <comment>%d</comment> files.', count($paths)));

        if ($this->option('dry-run')) {
            foreach ($paths as $path) {
                $this->line("  $path");
            }
            return self::SUCCESS;
        }

        $this->info('Downloading…');
        $bar = $this->output->createProgressBar(count($paths));
        $bar->start();

        $failed = [];

        DownloadPublishFiles::downloadFiles($paths, function (string $path, $result) use ($bar, &$failed) {
            if ($result !== true) {
                $failed[$path] = $result;
            }
            $bar->advance();
        });

        $bar->finish();
        $this->newLine(2);

        if (!empty($failed)) {
            $this->warn(count($failed) . ' file(s) failed:');
            foreach ($failed as $path => $error) {
                $this->line("  <fg=red>✘</> $path — $error");
            }
            return self::FAILURE;
        }

        $this->info('✔ All files saved to storage/app/imports.');
        return self::SUCCESS;
    }
}