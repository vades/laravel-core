<?php

// Path: database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Enums\ContentContentType;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeederProject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vadesProjectId = Project::where('slug', 'vades')->first()->id;
        $this->storeData('data/vades-article-categories.csv',  $vadesProjectId,ContentContentType::Article->value);
        /*$ivnbgProjectId = Project::where('slug', 'ivnbg')->first()->id;
        $this->storeData('data/ivnbg-categories.csv', $ivnbgProjectId,'place');*/
    }

    private function storeData(string $filePath, int $projectId, string $contentType): void
    {
        $csvPath = database_path($filePath);
        $rows = array_map('str_getcsv', file($csvPath));
        $header = array_map('trim', array_shift($rows));

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            // Set required fields not present in CSV
            $data['uuid']          = (string) Str::uuid();
            $data['project_id']    = $projectId;
            $data['content_type']  = $contentType;
            $data['status']        = 'published';
            $data['visibility']    = 'public';
            $data['lang']          = 'en';


            Category::create($data);
        }
    }
}