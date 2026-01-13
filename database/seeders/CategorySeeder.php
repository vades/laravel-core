<?php

// Path: database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectId = Project::where('slug', 'laravel-core')->first()->id;

        Category::factory()->count(3)->create([
                                                  'project_id' => $projectId,
                                                  'content_type' => 'post',
                                                  'status' => 'published',
                                                  'visibility' => 'public',
                                                  'lang' => 'en',
                                              ]);
    }
}