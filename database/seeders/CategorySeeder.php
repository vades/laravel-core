<?php

// Path: database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::factory()->count(3)->create([
            'project_id' => 6,
            'content_type' => 'post',
            'status' => 'published',
            'visibility' => 'public',
            'lang' => 'en',
        ]);
    }
}
