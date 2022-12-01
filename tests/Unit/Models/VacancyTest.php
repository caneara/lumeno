<?php

namespace Tests\Unit\Models;

use App\Models\Tool;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Requirement;
use Illuminate\Support\Facades\DB;

class VacancyTest extends ServerTest
{
    /** @test */
    public function it_knows_if_it_is_archived() : void
    {
        $vacancy_1 = Vacancy::factory()->create(['archived_at' => now()]);
        $vacancy_2 = Vacancy::factory()->create(['archived_at' => null]);

        $this->assertTrue($vacancy_1->isArchived());
        $this->assertFalse($vacancy_2->isArchived());
    }

    /** @test */
    public function it_knows_if_it_is_not_archived() : void
    {
        $vacancy_1 = Vacancy::factory()->create(['archived_at' => null]);
        $vacancy_2 = Vacancy::factory()->create(['archived_at' => now()]);

        $this->assertTrue($vacancy_1->isNotArchived());
        $this->assertFalse($vacancy_2->isNotArchived());
    }

    /** @test */
    public function it_knows_if_it_has_sent_invitations() : void
    {
        $vacancy_1 = Vacancy::factory()->create();
        $vacancy_2 = Vacancy::factory()->create();
        $vacancy_3 = Vacancy::factory()->create();

        DB::table('vacancies')->where('id', $vacancy_1->id)->update(['metrics' => ['invitation_count' => 1]]);
        DB::table('vacancies')->where('id', $vacancy_2->id)->update(['metrics' => ['invitation_count' => 0]]);

        $this->assertTrue($vacancy_1->fresh()->hasSentInvitations());
        $this->assertFalse($vacancy_2->fresh()->hasSentInvitations());
        $this->assertFalse($vacancy_3->fresh()->hasSentInvitations());
    }

    /** @test */
    public function it_knows_if_it_has_not_sent_invitations() : void
    {
        $vacancy_1 = Vacancy::factory()->create();
        $vacancy_2 = Vacancy::factory()->create();
        $vacancy_3 = Vacancy::factory()->create();

        DB::table('vacancies')->where('id', $vacancy_1->id)->update(['metrics' => ['invitation_count' => 1]]);
        DB::table('vacancies')->where('id', $vacancy_2->id)->update(['metrics' => ['invitation_count' => 0]]);

        $this->assertFalse($vacancy_1->fresh()->hasNotSentInvitations());
        $this->assertTrue($vacancy_2->fresh()->hasNotSentInvitations());
        $this->assertTrue($vacancy_3->fresh()->hasNotSentInvitations());
    }

    /** @test */
    public function it_can_order_requirements_by_priority() : void
    {
        $tool = Tool::factory()->create();

        $vacancy = Vacancy::factory()->create();

        $requirement_1 = Requirement::factory()
            ->belongsTo($vacancy, $tool)
            ->create(['optional' => true]);

        $requirement_2 = Requirement::factory()
            ->belongsTo($vacancy, $tool)
            ->create(['optional' => false]);

        $requirement_3 = Requirement::factory()
            ->belongsTo($vacancy, $tool)
            ->create(['optional' => true]);

        $this->assertEquals(
            collect([$requirement_2, $requirement_1, $requirement_3])->pluck('id'),
            $vacancy->orderRequirementsByPriority()->requirements->pluck('id')
        );
    }
}
