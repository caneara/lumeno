<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Models\School;
use App\Types\ServerTest;

class SchoolTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_schools_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('schools'))
            ->assertSuccessful()
            ->assertPage('schools.index');
    }

    /** @test */
    public function a_user_can_store_a_school() : void
    {
        $user = User::factory()->create();

        $school = School::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('schools.store'), $school->toArray())
            ->assertRedirect(route('schools'))
            ->assertNotification('The school has been created');

        $this->assertCount(1, School::get());

        $this->assertTrue(School::first()->user->is($user));

        $this->assertEquals($school->name, School::first()->name);
        $this->assertEquals($school->course, School::first()->course);
        $this->assertEquals($school->location, School::first()->location);
        $this->assertEquals($school->started_at, School::first()->started_at);
        $this->assertEquals($school->finished_at, School::first()->finished_at);
        $this->assertEquals($school->qualification, School::first()->qualification);
    }

    /** @test */
    public function a_user_cannot_store_a_school_if_they_have_reached_the_maximum_number_of_schools() : void
    {
        $user = User::factory()->create();

        config(['system.limits.schools' => 1]);

        School::factory()
            ->belongsTo($user)
            ->create();

        $school = School::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('schools.store'), $school->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_a_school() : void
    {
        $user = User::factory()->create();

        $school = School::factory()
            ->belongsTo($user)
            ->create();

        $payload = School::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->patchJson(route('schools.update', ['school' => $school]), $payload->toArray())
            ->assertRedirect(route('schools'))
            ->assertNotification('The school has been updated');

        $this->assertEquals($school->fresh()->name, $payload->name);
        $this->assertEquals($school->fresh()->course, $payload->course);
        $this->assertEquals($school->fresh()->location, $payload->location);
        $this->assertEquals($school->fresh()->started_at, $payload->started_at);
        $this->assertEquals($school->fresh()->finished_at, $payload->finished_at);
        $this->assertEquals($school->fresh()->qualification, $payload->qualification);
    }

    /** @test */
    public function a_user_can_delete_a_school() : void
    {
        $user = User::factory()->create();

        $school = School::factory()
            ->belongsTo($user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('schools.delete', ['school' => $school]))
            ->assertRedirect(route('schools'))
            ->assertNotification('The school has been deleted');

        $this->assertCount(0, School::get());
    }
}
