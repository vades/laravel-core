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
                'metadata' => ['url' => 'www.ivnbg.com'],
            ],
            [
                'slug' => 'Project::MartinVach->value',
                'excerpt' => 'martinvach.com project',
                'metadata' => ['url' => 'www.martinvach.com'],
            ],
            [
                'slug' => AppProject::MyPrompties->value,
                'excerpt' => 'myprompties.com project',
                'metadata' => ['url' => 'www.myprompties.com'],
            ],
            [
                'slug' => AppProject::MyPrompties->value,
                'excerpt' => 'vades.dev project',
                'metadata' => ['url' => 'www.vades.dev'],
            ],
            [
                'slug' => AppProject::Aitomatix->value,
                'excerpt' => 'aitomatix.com project',
                'metadata' => ['url' => 'www.aitomatix.com'],
            ],
            [
                'slug' => AppProject::LaravelCore->value,
                'excerpt' => 'laravel-core.test project. Only for local testing purposes.',
                'metadata' => null,
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