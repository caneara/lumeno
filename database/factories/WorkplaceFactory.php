<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;

class WorkplaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'user_id'     => User::factory(),
            'employer'    => fake()->company(),
            'role'        => fake()->jobTitle(),
            'location'    => fake()->city() . ', ' . fake()->state(),
            'summary'     => fake()->text(300),
            'started_at'  => $start = now()->subYears(rand(1, 5))->subDays(rand(5, 300)),
            'finished_at' => $start->addYears(rand(3, 4))->addDays(rand(5, 300)),
        ];
    }
}
