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
                'name' => 'ivnbg',
                'description' => 'ivnbg.com project',
                'metadata' => ['url' => 'www.ivnbg.com'],
            ],
            [
                'name' => 'martinvach',
                'description' => 'martinvach.com project',
                'metadata' => ['url' => 'www.martinvach.com'],
            ],
            [
                'name' => 'myprompties',
                'description' => 'myprompties.com project',
                'metadata' => ['url' => 'www.myprompties.com'],
            ],
            [
                'name' => 'vades.dev',
                'description' => 'vades.dev project',
                'metadata' => ['url' => 'www.vades.dev'],
            ],
            [
                'name' => 'aitomatix.com',
                'description' => 'aitomatix.com project',
                'metadata' => ['url' => 'www.aitomatix.com'],
            ],
            [
                'name' => 'laravel-core.test',
                'description' => 'laravel-core.test project. Only for local testing purposes.',
                'metadata' => null,
            ],
        ];

        // 2. Loop and use firstOrCreate for each project
        foreach ($projects as $projectData) {
            Project::firstOrCreate(
                ['name' => $projectData['name']], // Search key (Unique)
                [
                    'description' => $projectData['description'],
                    'metadata' => $projectData['metadata'] ?? null,
                ]
            );
        }

        // 3. Create the Test User
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Search key (Unique)
            [
                'name' => 'Test User',
                'project_id' => Project::where('name', 'laravel-core.test')->first()->id,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
