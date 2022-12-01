<?php

namespace Tests\Unit\Search\Sorters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Sorters\EmigrationSorter;

class EmigrationTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_sort() : void
    {
        $vacancy = Vacancy::factory()->create([
            'country'  => 1,
            'emigrate' => true,
        ]);

        $user_1 = User::factory()->create(['country' => 2]);
        $user_2 = User::factory()->create(['country' => 3]);
        $user_3 = User::factory()->create(['country' => 1]);

        $results = EmigrationSorter::execute($vacancy, User::query())->get();

        $this->assertCount(3, $results);

        $this->assertTrue($results[0]->is($user_3));
        $this->assertTrue($results[1]->is($user_1));
        $this->assertTrue($results[2]->is($user_2));
    }
}
