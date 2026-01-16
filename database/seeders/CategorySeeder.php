<?php

// Path: database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use App\Models\Category;
use App\Enums\AppProject;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectId = Project::where('slug', AppProject::LaravelCore->value)->first()->id;

        Category::factory()->count(10)->create([
                                                  'project_id' => $projectId,
                                                   'content_type' => ContentContentType::Article->value,
                                                   'status' =>ContentStatus::Published->value,
                                                   'visibility' =>ContentVisibility::Public->value,
                                                   'lang' => Language::EN->value,
                                              ]);
    }
}