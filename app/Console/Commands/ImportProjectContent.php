<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Import\ProjectContentService;
class ImportProjectContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-project-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traverse project directories and import markdown content into the database';

    /**
     * Execute the console command.
     */
    public function handle(ProjectContentService $service): int
    {
        $this->info('Starting project content import...');
        $this->newLine();

        // Run the import logic
        $service->handle();

        // Output Successes
        if (count($service->getSuccess()) > 0) {
            $this->info('Successfully imported:');
            foreach ($service->getSuccess() as $message) {
                $this->line("- <info>OK:</info> {$message}");
            }
        }

        $this->newLine();

        // Output Errors
        if (count($service->getErrors()) > 0) {
            $this->error('Errors encountered during import:');
            foreach ($service->getErrors() as $error) {
                $this->line("- <error>FAIL:</error> {$error}");
            }
        }

        $this->newLine();
        $this->info('Import process completed.');

        return Command::SUCCESS;
    }
}