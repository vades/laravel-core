<?php
// Path: database/seeders/ProjectSeeder.php

namespace Database\Seeders;

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
                'slug' => 'ivnbg',
                'excerpt' => 'ivnbg.com project',
                'metadata' => ['url' => 'www.ivnbg.com'],
            ],
            [
                'slug' => 'martinvach',
                'excerpt' => 'martinvach.com project',
                'metadata' => ['url' => 'www.martinvach.com'],
            ],
            [
                'slug' => 'myprompties',
                'excerpt' => 'myprompties.com project',
                'metadata' => ['url' => 'www.myprompties.com'],
            ],
            [
                'slug' => 'vades',
                'excerpt' => 'vades.dev project',
                'metadata' => ['url' => 'www.vades.dev'],
            ],
            [
                'slug' => 'aitomatix',
                'excerpt' => 'aitomatix.com project',
                'metadata' => ['url' => 'www.aitomatix.com'],
            ],
            [
                'slug' => 'laravel-core',
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