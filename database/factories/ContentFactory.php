<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    protected $model = Content::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lang = $this->faker->randomElement(['en', 'es', 'fr', 'de']);
        $title = $this->faker->unique()->sentence(6, true);
        $slug = Str::slug($title);

        return [
            'uuid' => $this->faker->uuid(),
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'author_id' => $this->faker->boolean(80) ? User::factory() : null,
            'parent_id' => $this->faker->boolean(20) ? Content::factory() : null,
            'content_type' => $this->faker->randomElement(['article', 'page', 'place','tutorial','prompt']),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'visibility' => $this->faker->randomElement(['public', 'private', 'unlisted']),
            'lang' => $lang,
            'slug' => $slug,
            'title' => $title,
            'subtitle' => $this->faker->boolean(60) ? $this->faker->sentence(8, true) : null,
            'excerpt' => $this->faker->boolean(80) ? $this->faker->paragraph() : null,
            'content' => $this->faker->boolean(90) ? $this->faker->paragraphs($this->faker->numberBetween(3, 8), true) : null,
            'metadata' => $this->faker->boolean(30) ? json_encode(['ref' => $this->faker->uuid, 'featured_image' => $this->faker->imageUrl()]) : null,
            'position' => $this->faker->numberBetween(0, 20),
            'is_featured' => $this->faker->boolean(10),
            'published_at' => $this->faker->boolean(70) ? $this->faker->dateTimeBetween('-2 years', 'now') : null,
            // ...timestamps and softDeletes handled by Eloquent...
        ];
    }
}