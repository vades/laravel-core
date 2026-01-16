<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Database\Seeder;

class CategoryContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Use withoutGlobalScopes() to bypass the FilterByProject trait
        $categories = Category::withoutGlobalScopes()->get();
        $contents = Content::withoutGlobalScopes()->get();

        // 2. Quick check to see if we actually have data to work with
        if ($categories->isEmpty() || $contents->isEmpty()) {
            $this->command->warn("Seeding skipped: Ensure 'categories' and 'contents' tables have data first.");
            return;
        }

        // 3. Attach relationships
        $categories->each(function ($category) use ($contents) {
            // Pick a random number of items to attach (e.g., between 1 and 3)
            $randomContents = $contents->random(min(rand(1, 3), $contents->count()));

            $category->contents()->attach($randomContents->pluck('id'));
        });

        $this->command->info("Successfully linked categories and content.");
    }
}