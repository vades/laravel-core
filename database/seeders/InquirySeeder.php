<?php

namespace Database\Seeders;

use App\Enums\AppProject;
use Illuminate\Database\Seeder;
use App\Models\Inquiry;
use App\Models\Project;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $projectId = Project::where('slug',AppProject::LaravelCore->value)->first()->id;

        Inquiry::factory()->count(50)->create([
            'project_id' => $projectId,
        ]);
    }
}