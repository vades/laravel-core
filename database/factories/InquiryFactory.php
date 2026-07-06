<?php

namespace Database\Factories;

use App\Enums\AppProject;
use App\Models\Inquiry;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectId = Project::where('slug', AppProject::LaravelCore->value)->first()->id;
        return [
            'project_id' =>$projectId,
            'user_id' => $this->faker->boolean(80) ? 1 : null,
            'is_read' => $this->faker->boolean(),
            'is_spam' => $this->faker->boolean(10),
            'is_archived' => $this->faker->boolean(10),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'subject' => $this->faker->boolean(85) ? $this->faker->sentence(6, true) : null,
            'message' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'ip_address' => $this->faker->boolean(90) ? $this->faker->ipv4() : null,
            'user_agent' => $this->faker->boolean(90) ? $this->faker->userAgent() : null,
            'terms_accepted_at' => $this->faker->boolean(95) ? $this->faker->dateTimeBetween('-2 years', 'now') : null,
            'metadata' => $this->faker->boolean(20) ? json_encode(['referrer' => $this->faker->url()]) : null,
            // ...timestamps and softDeletes handled by Eloquent...
        ];
    }
}