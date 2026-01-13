<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\Project;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = Project::query()->where('slug', 'laravel-core')->value('id');

        Content::factory()->count(50)->create([
                                                  'project_id' => $projectId,
                                                  'content_type' => 'article',
                                                  'status' => 'published',
                                                  'visibility' => 'public',
                                                  'lang' => 'en',
        ]);
    }
}