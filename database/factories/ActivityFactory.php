<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Replace with dynamic user ID in seeder
            'goal_id' => 1, // Replace with dynamic goal ID in seeder
            'type' => $this->faker->randomElement(['goal_created', 'goal_updated', 'goal_completed']),
            'description' => $this->faker->sentence,
            'changes' => json_encode(['key' => 'value']),
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
        ];
    }
}