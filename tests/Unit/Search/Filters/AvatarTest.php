<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\AvatarFilter;

class AvatarTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $vacancy = Vacancy::factory()->create();

        $user_1 = User::factory()->create(['avatar' => uuid()]);
        $user_2 = User::factory()->create(['avatar' => null]);

        $results = AvatarFilter::execute($vacancy, User::query())->get();

        $this->assertCount(1, $results);

        $this->assertTrue($results->first()->is($user_1));
    }
}
