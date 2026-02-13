<?php
// Path: database/seeders/ProjectSeeder.php

namespace Database\Seeders;

use App\Enums\AppProject;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'slug' =>AppProject::Ivnbg->value,
                'excerpt' => 'ivnbg.com project',
              'url' => 'https://www.ivnbg.com',
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::MartinVach->value,
                'excerpt' => 'martinvach.com project',
                'url' => 'https://www.martinvach.com',
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::MyPrompties->value,
                'excerpt' => 'myprompties.com project',
                'url' => 'https://www.myprompties.com',
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::Vades->value,
                'excerpt' => 'vades.dev project',
                'url' => 'https://www.vades.dev',
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::Aitomatix->value,
                'excerpt' => 'aitomatix.com project',
                'url' => 'https://www.aitomatix.com',
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::LaravelCore->value,
                'excerpt' => 'laravel-core.test project. Only for local testing purposes.',
                'url' => 'http://laravel-core.test',
                    'metadata' => [ ],
            ],
        ];

        foreach ($projects as &$project) {
            if (is_array($project['metadata']) || is_object($project['metadata'])) {
                $project['metadata'] = json_encode($project['metadata']);
            }
        }
        unset($project);

        Project::upsert(
            $projects,
            ['slug'],
            ['excerpt', 'metadata']
        );
    }
}