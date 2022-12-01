<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Member;
use App\Types\Factory;
use App\Models\Organization;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'organization_id' => Organization::factory(),
            'user_id'         => User::factory(),
            'role'            => Member::ROLE_MANAGER,
        ];
    }
}
