<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\CommitmentFilter;

class CommitmentTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $vacancy_1 = Vacancy::factory()->create(['commitment' => Vacancy::COMMITMENT_FULL_TIME]);
        $vacancy_2 = Vacancy::factory()->create(['commitment' => Vacancy::COMMITMENT_PART_TIME]);
        $vacancy_3 = Vacancy::factory()->create(['commitment' => Vacancy::COMMITMENT_CONTRACT]);

        $user_1 = User::factory()->create([
            'full_time'  => true,
            'part_time'  => false,
            'contract'   => false,
        ]);

        $user_2 = User::factory()->create([
            'full_time' => false,
            'part_time' => true,
            'contract'  => false,
        ]);

        $user_3 = User::factory()->create([
            'full_time' => false,
            'part_time' => false,
            'contract'  => true,
        ]);

        $results_1 = CommitmentFilter::execute($vacancy_1, User::query())->get();
        $results_2 = CommitmentFilter::execute($vacancy_2, User::query())->get();
        $results_3 = CommitmentFilter::execute($vacancy_3, User::query())->get();

        $this->assertCount(1, $results_1);
        $this->assertCount(1, $results_2);
        $this->assertCount(1, $results_3);

        $this->assertTrue($results_1[0]->is($user_1));
        $this->assertTrue($results_2[0]->is($user_2));
        $this->assertTrue($results_3[0]->is($user_3));
    }
}
