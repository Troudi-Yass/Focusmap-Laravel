<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'goal_id' => 1, // Replace with dynamic goal ID in seeder
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'completed' => $this->faker->boolean,
            'priority' => $this->faker->numberBetween(1, 3),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}