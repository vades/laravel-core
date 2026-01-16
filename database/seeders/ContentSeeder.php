<?php

namespace Database\Seeders;

use App\Enums\AppProject;
use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;
use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\Project;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = Project::query()->where('slug', AppProject::LaravelCore->value)->value('id');

        Content::factory()->count(50)->create([
                                                  'project_id' => $projectId,
                                                  'content_type' => ContentContentType::Article->value,
                                                  'status' =>ContentStatus::Published->value,
                                                  'visibility' =>ContentVisibility::Public->value,
                                                  'lang' => Language::EN->value,
        ]);
    }
}