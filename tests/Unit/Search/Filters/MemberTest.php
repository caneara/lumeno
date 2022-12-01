<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Member;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Organization;
use App\Search\Filters\MemberFilter;

class MemberTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $organization_1 = Organization::factory()->create();
        $organization_2 = Organization::factory()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $user_3 = User::factory()->create();

        Member::factory()
            ->belongsTo($organization_1, $user_1)
            ->create();

        Member::factory()
            ->belongsTo($organization_2, $user_2)
            ->create();

        $vacancy_1 = Vacancy::factory()
            ->belongsTo($organization_1)
            ->create();

        $vacancy_2 = Vacancy::factory()
            ->belongsTo($organization_2)
            ->create();

        $results_1 = MemberFilter::execute($vacancy_1, User::query()->select(['users.id']))->orderBy('users.id')->get();
        $results_2 = MemberFilter::execute($vacancy_2, User::query()->select(['users.id']))->orderBy('users.id')->get();

        $this->assertCount(2, $results_1);
        $this->assertCount(2, $results_2);

        $this->assertTrue($results_1[0]->is($user_2));
        $this->assertTrue($results_1[1]->is($user_3));

        $this->assertTrue($results_2[0]->is($user_1));
        $this->assertTrue($results_2[1]->is($user_3));
    }
}
