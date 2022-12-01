<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Models\User;
use App\Types\Factory;
use App\Collections\YearsExperienceCollection;

class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'user_id' => User::factory(),
            'tool_id' => Tool::factory(),
            'years'   => YearsExperienceCollection::make()->random()->id,
            'summary' => fake()->text(100),
        ];
    }
}
