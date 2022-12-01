<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;
use App\Models\Vacancy;
use App\Models\Organization;

class InvitationFactory extends Factory
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
            'user_id'         => User::factory(),
            'sending_at'      => null,
            'sent_at'         => null,
        ];
    }
}
