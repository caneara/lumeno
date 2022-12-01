<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;
use App\Collections\EducationalQualificationCollection;

class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'user_id'       => User::factory(),
            'qualification' => EducationalQualificationCollection::make()->random()->id,
            'name'          => fake()->company(),
            'course'        => fake()->jobTitle(),
            'location'      => fake()->city() . ', ' . fake()->state(),
            'started_at'    => $start = now()->subYears(rand(1, 5))->subDays(rand(5, 300)),
            'finished_at'   => $start->addYears(rand(3, 4))->addDays(rand(5, 300)),
        ];
    }
}
