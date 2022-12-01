<?php

namespace Tests\Unit\Search\Filters;

use App\Models\User;
use App\Models\School;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Search\Filters\QualificationFilter;

class QualificationTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_filter() : void
    {
        $vacancy_1 = Vacancy::factory()->create(['degree' => false]);
        $vacancy_2 = Vacancy::factory()->create(['degree' => true]);

        $user_1 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_STUDYING])
            ->create();

        $user_2 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_CERTIFICATE])
            ->create();

        $user_3 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_ASSOCIATE_DEGREE])
            ->create();

        $user_4 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_BACHELOR_DEGREE])
            ->create();

        $user_5 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_MASTERS_DEGREE])
            ->create();

        $user_6 = User::factory()
            ->hasSchools(['qualification' => School::QUALIFICATION_DOCTORAL_DEGREE])
            ->create();

        $results_1 = QualificationFilter::execute($vacancy_1, User::query()->select(['users.id']))->orderBy('id')->get();
        $results_2 = QualificationFilter::execute($vacancy_2, User::query()->select(['users.id']))->orderBy('id')->get();

        $this->assertCount(6, $results_1);
        $this->assertCount(4, $results_2);

        $this->assertTrue($results_1[0]->is($user_1));
        $this->assertTrue($results_1[1]->is($user_2));
        $this->assertTrue($results_1[2]->is($user_3));
        $this->assertTrue($results_1[3]->is($user_4));
        $this->assertTrue($results_1[4]->is($user_5));
        $this->assertTrue($results_1[5]->is($user_6));

        $this->assertTrue($results_2[0]->is($user_3));
        $this->assertTrue($results_2[1]->is($user_4));
        $this->assertTrue($results_2[2]->is($user_5));
        $this->assertTrue($results_2[3]->is($user_6));
    }
}
