<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Models\Workplace;
use App\Types\ServerTest;

class WorkplaceTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_workplaces_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('workplaces'))
            ->assertSuccessful()
            ->assertPage('workplaces.index');
    }

    /** @test */
    public function a_user_can_store_a_workplace() : void
    {
        $user = User::factory()->create();

        $workplace = Workplace::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('workplaces.store'), $workplace->toArray())
            ->assertRedirect(route('workplaces'))
            ->assertNotification('The workplace has been created');

        $this->assertCount(1, Workplace::get());

        $this->assertTrue(Workplace::first()->user->is($user));

        $this->assertEquals($workplace->role, Workplace::first()->role);
        $this->assertEquals($workplace->summary, Workplace::first()->summary);
        $this->assertEquals($workplace->employer, Workplace::first()->employer);
        $this->assertEquals($workplace->location, Workplace::first()->location);
        $this->assertEquals($workplace->started_at, Workplace::first()->started_at);
        $this->assertEquals($workplace->finished_at, Workplace::first()->finished_at);
    }

    /** @test */
    public function a_user_cannot_store_a_workplace_if_they_have_reached_the_maximum_number_of_workplaces() : void
    {
        $user = User::factory()->create();

        config(['system.limits.workplaces' => 1]);

        Workplace::factory()
            ->belongsTo($user)
            ->create();

        $workplace = Workplace::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->postJson(route('workplaces.store'), $workplace->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_a_workplace() : void
    {
        $user = User::factory()->create();

        $workplace = Workplace::factory()
            ->belongsTo($user)
            ->create();

        $payload = Workplace::factory()
            ->belongsTo($user)
            ->make();

        $this->actingAs($user)
            ->patchJson(route('workplaces.update', ['workplace' => $workplace]), $payload->toArray())
            ->assertRedirect(route('workplaces'))
            ->assertNotification('The workplace has been updated');

        $this->assertEquals($workplace->fresh()->role, $payload->role);
        $this->assertEquals($workplace->fresh()->summary, $payload->summary);
        $this->assertEquals($workplace->fresh()->employer, $payload->employer);
        $this->assertEquals($workplace->fresh()->location, $payload->location);
        $this->assertEquals($workplace->fresh()->started_at, $payload->started_at);
        $this->assertEquals($workplace->fresh()->finished_at, $payload->finished_at);
    }

    /** @test */
    public function a_user_can_delete_a_workplace() : void
    {
        $user = User::factory()->create();

        $workplace = Workplace::factory()
            ->belongsTo($user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('workplaces.delete', ['workplace' => $workplace]))
            ->assertRedirect(route('workplaces'))
            ->assertNotification('The workplace has been deleted');

        $this->assertCount(0, Workplace::get());
    }
}
