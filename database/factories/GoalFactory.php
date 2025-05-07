<?php

namespace Database\Factories;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Replace with dynamic user ID in seeder
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'icon' => 'ri-flag-line',
            'category' => $this->faker->word,
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'progress' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['not_started', 'in_progress', 'completed']),
        ];
    }
}