<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\LanguageFilter;

class LanguageTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $vacancy = Vacancy::factory()->create([
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => null,
        ]);

        $user_1 = User::factory()->create([
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => 3,
        ]);

        $user_2 = User::factory()->create([
            'first_language'  => 1,
            'second_language' => 2,
            'third_language'  => null,
        ]);

        $user_3 = User::factory()->create([
            'first_language'  => 3,
            'second_language' => 4,
            'third_language'  => null,
        ]);

        $user_4 = User::factory()->create([
            'first_language'  => 5,
            'second_language' => null,
            'third_language'  => null,
        ]);

        $results = LanguageFilter::execute($vacancy, User::query())->get();

        $this->assertCount(2, $results);

        $this->assertTrue($results[0]->is($user_1));
        $this->assertTrue($results[1]->is($user_2));
    }
}
