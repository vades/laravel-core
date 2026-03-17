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
              'url' => AppProject::Ivnbg->getUrl(),
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::MartinVach->value,
                'excerpt' => 'martinvach.com project',
                'url' => AppProject::MartinVach->getUrl(),
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::MyPrompties->value,
                'excerpt' => 'myprompties.com project',
                'url' => AppProject::MyPrompties->getUrl(),
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::Vades->value,
                'excerpt' => 'vades.dev project',
                'url' => AppProject::Vades->getUrl(),
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::Aitomatix->value,
                'excerpt' => 'aitomatix.com project',
                'url' => AppProject::Aitomatix->getUrl(),
                'metadata' => [ ],
            ],
            [
                'slug' => AppProject::LaravelCore->value,
                'excerpt' => 'laravel-core.test project. Only for local testing purposes.',
                'url' => AppProject::LaravelCore->getUrl(),
                    'metadata' => [ ],
            ],
            [
                'slug' => AppProject::LaravelCoreVades->value,
                'excerpt' => 'laravel-core.vades.dev project. Only for local testing purposes.',
                'url' => AppProject::LaravelCoreVades->getUrl(),
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