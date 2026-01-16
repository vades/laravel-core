<?php
// Path: database/factories/CategoryFactory.php

namespace Database\Factories;

use App\Enums\AppProject;
use App\Models\Category;
use App\Models\Project; // Assuming this model exists based on naming conventions
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ContentContentType;
use App\Enums\ContentStatus;
use App\Enums\ContentVisibility;
use App\Enums\Language;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectId = Project::where('slug', AppProject::LaravelCore->value)->first()->id;
        return [
            'uuid' => $this->faker->unique()->uuid(),

            // Constraint Note: Input requested specific ID '6' for mockup.
            // Standard practice: Project::factory()
            'project_id' => $projectId,

            // Self-referencing relation. Default to null to avoid infinite recursion loops.
            // You can use ->state() methods to create children specifically.
            'parent_id' => null,

            'status' => $this->faker->randomElement(array_column(ContentStatus::cases(), 'value')),

            'visibility' => $this->faker->randomElement(array_column(ContentVisibility::cases(), 'value')),

            // Constraint Note: Input requested 'post' for mockup.
            'content_type' => $this->faker->randomElement(array_column(ContentContentType::cases(), 'value')),

            'position' => $this->faker->numberBetween(0, 100),

            // Unique constraint on [project_id, slug, lang].
            // Since project_id is static (6), slug must be unique.
            'slug' => $this->faker->unique()->slug(),

            'lang' => $this->faker->randomElement(array_column(Language::cases(), 'value')),
            'title' => $this->faker->sentence(4), // Generates a realistic title

            // Nullable logic: 80% chance of text, 20% chance of null
            'excerpt' => $this->faker->boolean(80) ? $this->faker->paragraph(2) : null,

            // Nullable logic: 50% chance of metadata
            'metadata' => $this->faker->boolean(50) ? [
                'keywords' => $this->faker->words(3),
                'author' => $this->faker->name(),
                'color' => $this->faker->hexColor()
            ] : null,

            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'deleted_at' => null, // Soft deletes are null by default
        ];
    }

    /**
     * Indicate that the category is a child of another category.
     */
    public function child(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => Category::factory(),
        ]);
    }
}