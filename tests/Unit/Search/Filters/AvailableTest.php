<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\AvailableFilter;

class AvailableTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $vacancy = Vacancy::factory()->create();

        $user_1 = User::factory()->create(['available' => true]);
        $user_2 = User::factory()->create(['available' => false]);

        $results = AvailableFilter::execute($vacancy, User::query())->get();

        $this->assertCount(1, $results);

        $this->assertTrue($results->first()->is($user_1));
    }
}
