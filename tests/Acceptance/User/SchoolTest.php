<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Models\School;
use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Collections\EducationalQualificationCollection;

class SchoolTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_schools_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()
                ->with(School::class)
                ->create();

            $browser->loginAs($user)
                ->visitRoute('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee(School::first()->course)
                ->assertSee(Str::upper(EducationalQualificationCollection::find(School::first()->qualification)->name))
                ->assertSee(School::first()->name)
                ->assertSee(School::first()->location)
                ->assertSee(School::first()->started_at->date())
                ->assertSee(School::first()->finished_at->date());

            $browser->assertSee('1 school')
                ->assertSee('10 permitted')
                ->assertSee('9 remaining');
        });
    }

    /** @test */
    public function a_user_can_store_a_school() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $school = School::factory()
                ->belongsTo($user)
                ->make();

            $browser->loginAs($user)
                ->visitRoute('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->action('create-school');

            $browser->assertSee('Add a new school');

            $browser->type('course', $school->course)
                ->select('qualification', $school->qualification)
                ->type('name', $school->name)
                ->type('location', $school->location)
                ->date('started_at', $school->started_at)
                ->date('finished_at', $school->finished_at)
                ->push('create');

            $browser->assertRouteIs('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee('The school has been created');

            $browser->assertSee($school->course)
                ->assertSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                ->assertSee($school->name)
                ->assertSee($school->location)
                ->assertSee($school->started_at->date())
                ->assertSee($school->finished_at->date());
        });
    }

    /** @test */
    public function a_user_can_update_a_school() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $school = School::factory()
                ->belongsTo($user)
                ->create();

            $payload = School::factory()
                ->belongsTo($user)
                ->make();

            $browser->loginAs($user)
                ->visitRoute('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee($school->course)
                ->assertSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                ->assertSee($school->name)
                ->assertSee($school->location)
                ->assertSee($school->started_at->date())
                ->assertSee($school->finished_at->date());

            $browser->context("schools-{$school->id}", "schools-{$school->id}-edit");

            $browser->assertSee('Edit an existing school');

            $browser->assertInputValue('course', $school->course)
                ->assertSelected('qualification', $school->qualification)
                ->assertInputValue('name', $school->name)
                ->assertInputValue('location', $school->location)
                ->assertDate('started_at', $school->started_at)
                ->assertDate('finished_at', $school->finished_at);

            $browser->type('course', $payload->course)
                ->select('qualification', $payload->qualification)
                ->type('name', $payload->name)
                ->type('location', $payload->location)
                ->date('started_at', $payload->started_at)
                ->date('finished_at', $payload->finished_at)
                ->push('update');

            $browser->assertRouteIs('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee('The school has been updated');

            $browser->assertSee($payload->course)
                ->assertSee(Str::upper(EducationalQualificationCollection::find($payload->qualification)->name))
                ->assertSee($payload->name)
                ->assertSee($payload->location)
                ->assertSee($payload->started_at->date())
                ->assertSee($payload->finished_at->date());
        });
    }

    /** @test */
    public function a_user_can_delete_a_school() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $school = School::factory()
                ->belongsTo($user)
                ->create();

            $browser->loginAs($user)
                ->visitRoute('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee($school->course)
                ->assertSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                ->assertSee($school->name)
                ->assertSee($school->location)
                ->assertSee($school->started_at->date())
                ->assertSee($school->finished_at->date());

            $browser->context("schools-{$school->id}", "schools-{$school->id}-delete");

            $browser->assertRouteIs('schools')
                ->assertTitle('Schools')
                ->assertSee('Schools');

            $browser->assertSee('The school has been deleted');

            $browser->assertDontSee($school->course)
                ->assertDontSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                ->assertDontSee($school->name)
                ->assertDontSee($school->location)
                ->assertDontSee($school->started_at->date())
                ->assertDontSee($school->finished_at->date());
        });
    }
}
