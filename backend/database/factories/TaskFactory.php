<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectId = Project::inRandomOrder()->value('id') ?? Project::factory();
        $userId    = User::inRandomOrder()->value('id') ?? User::factory();

        return [
            'project_id'   => $projectId,
            'user_id'      => $userId,
            'name'         => $this->faker->sentence(4),
            'description'  => $this->faker->optional()->realText(200),
            'status'       => $this->faker->randomElement(['todo','doing','done']),
            'priority'     => $this->faker->randomElement(['low','medium','high']),
            'due_date'     => $this->faker->optional(0.6)->dateTimeBetween('now','+2 months'),
            'completed_at' => null,
            'position'     => $this->faker->numberBetween(0, 1000),
        ];
    }
}
