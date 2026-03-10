<?php

namespace App\Console\Commands;

use App\Services\Album\AlbumGeneratorService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateAlbum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-album {--url=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate album';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->option('url');
        if(empty($url)) {
            $url = config('myapp.album.url');
        }
        $this->info('Generating albums: ');
        try {
            $service = new AlbumGeneratorService($url);
            $service->handle();

            $errors = $service->getErrors();
            foreach ($errors as $message) {
                $this->error($message);
                Log::error($message);
            }

            $success = $service->getSuccess();
            foreach ($success as $message) {
                $this->info($message);
                Log::info($message);
            }

        }catch (Exception $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }
    }
}
