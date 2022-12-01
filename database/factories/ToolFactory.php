<?php

namespace Database\Factories;

use App\Types\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

class ToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'category_id' => Category::factory(),
            'name'        => fake()->unique()->word . Str::random(10),
            'originated'  => 2010,
            'approved'    => true,
        ];
    }
}
