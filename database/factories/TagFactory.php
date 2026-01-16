<?php

namespace Database\Factories;

use App\Enums\AppProject;
use App\Enums\ContentContentType;
use App\Enums\Language;
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
        $projectId = Project::where('slug', AppProject::LaravelCore->value)->first()->id;
        return [
            'project_id' => $projectId,
            'content_type' => $this->faker->randomElement(array_column(ContentContentType::cases(), 'value')),
            'lang' => $this->faker->randomElement(array_column(Language::cases(), 'value')),
            'name' => $this->faker->unique()->words(2, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}