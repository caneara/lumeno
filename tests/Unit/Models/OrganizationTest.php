<?php

namespace Tests\Unit\Models;

use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Invitation;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Sequence;

class OrganizationTest extends ServerTest
{
    /** @test */
    public function it_knows_the_details_for_the_current_billing_cycle() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $sequence = new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDays(30)],
            ['created_at' => now()->subDays(30)->startOfDay()->subSecond()],
        );

        Invitation::factory()
            ->count(3)
            ->belongsTo($organization, $vacancy)
            ->state($sequence)
            ->create();

        $this->assertEquals(2, $organization->billing()->usage_this_cycle);
        $this->assertEquals(now()->endOfDay(), $organization->billing()->next_payment_date);
        $this->assertEquals(now()->subDays(30)->startOfDay(), $organization->billing()->last_payment_date);
    }
}
