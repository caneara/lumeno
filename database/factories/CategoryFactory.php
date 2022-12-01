<?php

namespace Database\Factories;

use App\Types\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'name' => fake()->unique()->word . Str::random(10),
        ];
    }
}
