<?php

namespace Database\Factories;

use App\Types\Factory;
use App\Models\Organization;

class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'billable_id'   => Organization::factory(),
            'billable_type' => Organization::class,
            'name'          => 'default',
            'paddle_id'     => rand(1, 2147483647),
            'paddle_status' => 'active',
            'paddle_plan'   => 25423,
            'quantity'      => 1,
            'trial_ends_at' => null,
            'paused_from'   => null,
            'ends_at'       => null,
        ];
    }
}
