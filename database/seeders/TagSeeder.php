<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->count(50)->create([
            'project_id' => 6,
            'content_type' => 'post',
            'lang' => 'en',
        ]);
    }
}