<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Types\ServerTest;
use Illuminate\Support\Facades\DB;
use App\Collections\CurrencyCollection;
use App\Search\Filters\RemunerationFilter;

class RemunerationTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        CurrencyCollection::seed();

        DB::table('currencies')->where('id', 1)->update(['rate' => 1]);
        DB::table('currencies')->where('id', 2)->update(['rate' => 1.177]);
        DB::table('currencies')->where('id', 3)->update(['rate' => 0.064]);
        DB::table('currencies')->where('id', 4)->update(['rate' => 3.309]);

        $vacancy_1 = Vacancy::factory()->create([
            'currency'     => 1,
            'remuneration' => 1000,
        ]);

        $vacancy_2 = Vacancy::factory()->create([
            'currency'     => 2,
            'remuneration' => 1500,
        ]);

        $vacancy_3 = Vacancy::factory()->create([
            'currency'     => 3,
            'remuneration' => 1000,
        ]);

        $vacancy_4 = Vacancy::factory()->create([
            'currency'     => 4,
            'remuneration' => 1000,
        ]);

        $user_1 = User::factory()->create([
            'currency'     => 1,
            'remuneration' => 1500,
        ]);

        $user_2 = User::factory()->create([
            'currency'     => 2,
            'remuneration' => 2000,
        ]);

        $user_3 = User::factory()->create([
            'currency'     => 3,
            'remuneration' => 1500,
        ]);

        $results_1 = RemunerationFilter::execute($vacancy_1, User::query()->select(['users.id']))->get();
        $results_2 = RemunerationFilter::execute($vacancy_2, User::query()->select(['users.id']))->get();
        $results_3 = RemunerationFilter::execute($vacancy_3, User::query()->select(['users.id']))->get();
        $results_4 = RemunerationFilter::execute($vacancy_4, User::query()->select(['users.id']))->get();

        $this->assertCount(1, $results_1);
        $this->assertCount(2, $results_2);
        $this->assertCount(0, $results_3);
        $this->assertCount(3, $results_4);

        $this->assertTrue($results_1[0]->is($user_3));

        $this->assertTrue($results_2[0]->is($user_1));
        $this->assertTrue($results_2[1]->is($user_3));

        $this->assertTrue($results_4[0]->is($user_1));
        $this->assertTrue($results_4[1]->is($user_2));
        $this->assertTrue($results_4[2]->is($user_3));
    }
}
