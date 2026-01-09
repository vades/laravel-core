<?php
// Path: database/factories/ProjectFactory.php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Unique slug (e.g., "project-alpha" or "cool-startup")
            'slug' => $this->faker->unique()->slug(2),

            // Nullable excerpt: 80% chance of text, 20% chance of null
            'excerpt' => $this->faker->boolean(80)
                ? $this->faker->paragraph(2)
                : null,

            // Nullable JSON metadata: 70% chance of data
            'metadata' => $this->faker->boolean(70) ? [
                'website' => $this->faker->url(),
                'client' => $this->faker->company(),
                'version' => $this->faker->semver(),
                'tags' => $this->faker->words(3),
            ] : null,

            // Standard timestamps are handled automatically,
            // but we can randomize creation time if desired
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),

            // Soft deletes default to null (active record)
            'deleted_at' => null,
        ];
    }
}
