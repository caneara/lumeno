<?php

namespace Tests\Unit\Search\Sorters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Sorters\IdSorter;

class IdTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_sort() : void
    {
        $vacancy = Vacancy::factory()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $user_3 = User::factory()->create();
        $user_4 = User::factory()->create();

        $results = IdSorter::execute($vacancy, User::query())->get();

        $this->assertCount(4, $results);

        $this->assertTrue($results[0]->is($user_4));
        $this->assertTrue($results[1]->is($user_3));
        $this->assertTrue($results[2]->is($user_2));
        $this->assertTrue($results[3]->is($user_1));
    }
}
