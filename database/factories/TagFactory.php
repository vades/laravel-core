<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectId = Project::where('slug', 'laravel-core')->first()->id;
        return [
            'project_id' => $projectId,
            'content_type' => $this->faker->randomElement(['article', 'video', 'image', 'audio']),
            'lang' => $this->faker->randomElement(['en', 'es', 'fr', 'de']),
            'name' => $this->faker->unique()->words(2, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}