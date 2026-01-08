<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Define the projects data
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

        // 2. Loop and use firstOrCreate for each project
        foreach ($projects as $projectData) {
            Project::firstOrCreate(
                ['slug' => $projectData['slug']], // Search key (Unique)
                [
                    'excerpt' => $projectData['excerpt'],
                    'metadata' => $projectData['metadata'] ?? null,
                ]
            );
        }

        // 3. Create the Test User
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Search key (Unique)
            [
                'name' => 'Test User',
                'project_id' => Project::where('slug', 'laravel-core.test')->first()->id,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
