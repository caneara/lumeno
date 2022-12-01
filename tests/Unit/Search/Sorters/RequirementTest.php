<?php

namespace Tests\Unit\Search\Sorters;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Models\Vacancy;
use App\Models\Category;
use App\Types\ServerTest;
use App\Models\Requirement;
use App\Search\Filters\RequirementFilter;
use App\Search\Sorters\RequirementSorter;
use Illuminate\Database\Eloquent\Factories\Sequence;

class RequirementTest extends ServerTest
{
    /** @test */
    public function it_can_perform_a_sort() : void
    {
        Category::factory()
            ->hasTools(3)
            ->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $user_3 = User::factory()->create();
        $user_4 = User::factory()->create();

        $sequence = new Sequence([
            'tool_id'  => Tool::first(),
            'years'    => 1,
            'optional' => false,
        ], [
            'tool_id'  => Tool::second(),
            'years'    => 2,
            'optional' => false,
        ], [
            'tool_id'  => Tool::third(),
            'years'    => 3,
            'optional' => true,
        ]);

        $vacancy = Vacancy::factory()
            ->with(3, Requirement::class, [], $sequence)
            ->create();

        Skill::factory()
            ->belongsTo($user_1, Tool::first())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo($user_1, Tool::second())
            ->create(['years' => 2]);

        Skill::factory()
            ->belongsTo($user_1, Tool::third())
            ->create(['years' => 3]);

        Skill::factory()
            ->belongsTo($user_2, Tool::first())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo($user_2, Tool::second())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo($user_2, Tool::third())
            ->create(['years' => 5]);

        Skill::factory()
            ->belongsTo($user_3, Tool::first())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo($user_3, Tool::second())
            ->create(['years' => 1]);

        Skill::factory()
            ->belongsTo($user_3, Tool::third())
            ->create(['years' => 5]);

        $query   = RequirementFilter::execute($vacancy, User::query()->select(['users.id']));
        $results = RequirementSorter::execute($vacancy, $query)->get();

        $this->assertCount(2, $results);

        $this->assertTrue($results[0]->is(User::second()));
        $this->assertTrue($results[1]->is(User::first()));
    }
}
