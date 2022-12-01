<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Types\Factory;
use App\Models\Vacancy;
use App\Models\Organization;
use App\Collections\YearsExperienceCollection;

class RequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'organization_id' => Organization::factory(),
            'vacancy_id'      => Vacancy::factory(),
            'tool_id'         => Tool::factory(),
            'years'           => YearsExperienceCollection::make()->random()->id,
            'summary'         => fake()->text(100),
            'optional'        => fake()->boolean(),
        ];
    }
}
