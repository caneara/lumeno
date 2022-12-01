<?php

namespace Tests\Acceptance\Organization;

use App\Models\Tool;
use App\Models\User;
use App\Models\Member;
use App\Types\Browser;
use App\Models\Vacancy;
use App\Models\Category;
use App\Types\ClientTest;
use App\Models\Requirement;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Collections\ToolCategoryCollection;

class RequirementTest extends ClientTest
{
    /** @test */
    public function a_user_can_store_a_requirement() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $tool = Tool::factory()->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->create();

            $requirement = Requirement::factory()
                ->belongsTo($organization, $vacancy, $tool)
                ->make([
                    'optional' => true,
                    'years'    => 2,
                ]);

            $browser->loginAs($user)
                ->visitRoute('vacancies.edit', ['vacancy' => $vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->push('add-requirement');

            $browser->within('.requirement', function($browser) use ($tool, $requirement) {
                $browser->lookup('tool_id', $tool->name, $tool->id)
                    ->select('years', $requirement->years)
                    ->type('summary', $requirement->summary)
                    ->check('optional', $requirement->optional)
                    ->push('save-requirement');
            });

            $browser->assertSee($tool->name)
                ->assertSee($tool->category->name)
                ->assertSee(Str::upper('2 years'))
                ->assertSee(Str::upper('Optional'));

            $browser->refresh()
                ->pause(3000);

            $browser->assertSee($tool->name)
                ->assertSee($tool->category->name)
                ->assertSee(Str::upper('2 years'))
                ->assertSee(Str::upper('Optional'));

            $requirement = Requirement::first();

            $browser->context("requirements-{$requirement->id}", "requirements-{$requirement->id}-edit");

            $browser->within('.requirement', function($browser) use ($tool, $requirement) {
                $browser->assertInputValue('tool_id', $tool->id)
                    ->assertSelected('years', $requirement->years)
                    ->assertInputValue('summary', $requirement->summary)
                    ->assertChecked('optional', $requirement->optional);
            });
        });
    }

    /** @test */
    public function a_user_can_update_a_requirement() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            ToolCategoryCollection::seed();

            $tool_1 = Tool::factory()
                ->belongsTo(Category::first())
                ->create(['name' => Str::random(10)]);

            $tool_2 = Tool::factory()
                ->belongsTo(Category::second())
                ->create(['name' => Str::random(10)]);

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->create();

            $requirement = Requirement::factory()
                ->belongsTo($organization, $vacancy, $tool_1)
                ->create([
                    'optional' => false,
                    'years'    => 4,
                ]);

            $payload = Requirement::factory()
                ->belongsTo($organization, $vacancy, $tool_2)
                ->make([
                    'optional' => true,
                    'years'    => 3,
                ]);

            $browser->loginAs($user)
                ->visitRoute('vacancies.edit', ['vacancy' => $vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->assertSee($tool_1->name)
                ->assertSee($tool_1->category->name)
                ->assertSee(Str::upper('4 years'))
                ->assertSee(Str::upper('Mandatory'));

            $browser->context("requirements-{$requirement->id}", "requirements-{$requirement->id}-edit");

            $browser->within('.requirement', function($browser) use ($tool_1, $tool_2, $requirement, $payload) {
                $browser->assertInputValue('tool_id', $tool_1->id)
                    ->assertSelected('years', $requirement->years)
                    ->assertInputValue('summary', $requirement->summary)
                    ->assertChecked('optional', $requirement->optional);

                $browser->lookup('tool_id', $tool_2->name, $tool_2->id)
                    ->select('years', $payload->years)
                    ->type('summary', $payload->summary)
                    ->check('optional', $payload->optional)
                    ->push('save-requirement');
            });

            $browser->assertDontSee($tool_1->name)
                ->assertDontSee($tool_1->category->name)
                ->assertDontSee(Str::upper('4 years'))
                ->assertDontSee(Str::upper('Mandatory'));

            $browser->assertSee($tool_2->name)
                ->assertSee($tool_2->category->name)
                ->assertSee(Str::upper('3 years'))
                ->assertSee(Str::upper('Optional'));

            $browser->refresh()
                ->pause(3000);

            $browser->assertDontSee($tool_1->name)
                ->assertDontSee($tool_1->category->name)
                ->assertDontSee(Str::upper('4 years'))
                ->assertDontSee(Str::upper('Mandatory'));

            $browser->assertSee($tool_2->name)
                ->assertSee($tool_2->category->name)
                ->assertSee(Str::upper('3 years'))
                ->assertSee(Str::upper('Optional'));

            $browser->context("requirements-{$requirement->id}", "requirements-{$requirement->id}-edit");

            $browser->within('.requirement', function($browser) use ($tool_2, $payload) {
                $browser->assertInputValue('tool_id', $tool_2->id)
                    ->assertSelected('years', $payload->years)
                    ->assertInputValue('summary', $payload->summary)
                    ->assertChecked('optional', $payload->optional);
            });
        });
    }

    /** @test */
    public function a_user_can_delete_a_requirement() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->create();

            $requirement = Requirement::factory()
                ->belongsTo($organization, $vacancy)
                ->create([
                    'optional' => false,
                    'years'    => 4,
                ]);

            $browser->loginAs($user)
                ->visitRoute('vacancies.edit', ['vacancy' => $vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->assertSee($requirement->tool->name)
                ->assertSee($requirement->tool->category->name)
                ->assertSee(Str::upper('4 years'))
                ->assertSee(Str::upper('Mandatory'));

            $browser->assertDontSee("You haven't added any requirements yet");

            $browser->context("requirements-{$requirement->id}", "requirements-{$requirement->id}-delete");

            $browser->assertDontSee($requirement->tool->name)
                ->assertDontSee($requirement->tool->category->name)
                ->assertDontSee(Str::upper('4 years'))
                ->assertDontSee(Str::upper('Mandatory'));

            $browser->assertSee("You haven't added any requirements yet");

            $browser->refresh()
                ->pause(3000);

            $browser->assertDontSee($requirement->tool->name)
                ->assertDontSee($requirement->tool->category->name)
                ->assertDontSee(Str::upper('4 years'))
                ->assertDontSee(Str::upper('Mandatory'));

            $browser->assertSee("You haven't added any requirements yet");
        });
    }
}
