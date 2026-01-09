<?php
// Path: database/seeders/ProjectSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We use the factory's sequence() method to iterate through specific states
        // while allowing the factory to generate the remaining required fields.

        Project::factory()
            ->count(6) // We have 6 specific projects defined below
            ->state(new Sequence(
                [
                    'slug' => 'ivnbg',
                    'excerpt' => 'ivnbg.com project',
                    'metadata' => ['url' => 'www.ivnbg.com']
                ],
                [
                    'slug' => 'martinvach',
                    'excerpt' => 'martinvach.com project',
                    'metadata' => ['url' => 'www.martinvach.com']
                ],
                [
                    'slug' => 'myprompties',
                    'excerpt' => 'myprompties.com project',
                    'metadata' => ['url' => 'www.myprompties.com']
                ],
                [
                    'slug' => 'vades',
                    'excerpt' => 'vades.dev project',
                    'metadata' => ['url' => 'www.vades.dev']
                ],
                [
                    'slug' => 'aitomatix',
                    'excerpt' => 'aitomatix.com project',
                    'metadata' => ['url' => 'www.aitomatix.com']
                ],
                [
                    'slug' => 'laravel-core',
                    'excerpt' => 'laravel-core.test project. Only for local testing purposes.',
                    'metadata' => null
                ],
            ))
            ->create();
    }
}
