<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $userId = User::inRandomOrder()->value('id') ?? User::factory();

        return [
            'user_id'    => $userId,
            'name'       => $this->faker->sentence(3),       
            'description'=> $this->faker->realText(120),
            'color'      => $this->faker->hexColor(),          
            'status'     => $this->faker->randomElement(['active','archived']),
        ];
    }
}
