<?php

namespace Database\Seeders;

use App\Enums\AppProject;
use App\Enums\ContentContentType;
use App\Enums\Language;
use App\Models\Project;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $projectId = Project::where('slug', AppProject::LaravelCore->value)->first()->id;
        Tag::factory()->count(50)->create([
            'project_id' =>  $projectId,
                                              'content_type' => ContentContentType::Article->value,
                                              'lang' => Language::EN->value,
        ]);
    }
}