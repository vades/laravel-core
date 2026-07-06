<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentTagSeeder extends Seeder
{
    public function run(): void
    {
        // Bypass global scopes to ensure we see all records in CLI
        $contents = Content::withoutGlobalScopes()->get();
        $tags = Tag::withoutGlobalScopes()->get();

        if ($contents->isEmpty() || $tags->isEmpty()) {
            $this->command->warn("Seeding skipped: Ensure 'contents' and 'tags' tables have data.");
            return;
        }

        // Loop through contents and attach 1-5 random tags to each
        $contents->each(function ($content) use ($tags) {
            $randomTags = $tags->random(min(rand(1, 5), $tags->count()));

            $content->tags()->attach($randomTags->pluck('id'));
        });

        $this->command->info("Successfully attached tags to content.");
    }
}