<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Types\Browser;
use App\Models\Workplace;
use App\Types\ClientTest;

class WorkplaceTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_workplaces_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $workplace = Workplace::factory()
                ->belongsTo($user)
                ->create();

            $browser->loginAs($user)
                ->visitRoute('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee($workplace->role)
                ->assertSee($workplace->employer)
                ->assertSee($workplace->location)
                ->assertSee($workplace->started_at->date())
                ->assertSee($workplace->finished_at->date());

            $browser->assertSee('1 workplace')
                ->assertSee('20 permitted')
                ->assertSee('19 remaining');
        });
    }

    /** @test */
    public function a_user_can_store_a_workplace() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $workplace = Workplace::factory()
                ->belongsTo($user)
                ->make();

            $browser->loginAs($user)
                ->visitRoute('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->action('create-workplace');

            $browser->assertSee('Add a new workplace');

            $browser->type('role', $workplace->role)
                ->type('employer', $workplace->employer)
                ->type('location', $workplace->location)
                ->type('summary', $workplace->summary)
                ->date('started_at', $workplace->started_at)
                ->date('finished_at', $workplace->finished_at)
                ->push('create');

            $browser->assertRouteIs('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee('The workplace has been created');

            $browser->assertSee($workplace->role)
                ->assertSee($workplace->employer)
                ->assertSee($workplace->location)
                ->assertSee($workplace->started_at->date())
                ->assertSee($workplace->finished_at->date());
        });
    }

    /** @test */
    public function a_user_can_update_a_workplace() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $workplace = Workplace::factory()
                ->belongsTo($user)
                ->create();

            $payload = Workplace::factory()
                ->belongsTo($user)
                ->make();

            $browser->loginAs($user)
                ->visitRoute('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee($workplace->role)
                ->assertSee($workplace->employer)
                ->assertSee($workplace->location)
                ->assertSee($workplace->started_at->date())
                ->assertSee($workplace->finished_at->date());

            $browser->context("workplaces-{$workplace->id}", "workplaces-{$workplace->id}-edit");

            $browser->assertSee('Edit an existing workplace');

            $browser->assertInputValue('role', $workplace->role)
                ->assertInputValue('employer', $workplace->employer)
                ->assertInputValue('location', $workplace->location)
                ->assertInputValue('summary', $workplace->summary)
                ->assertDate('started_at', $workplace->started_at)
                ->assertDate('finished_at', $workplace->finished_at);

            $browser->type('role', $payload->role)
                ->type('employer', $payload->employer)
                ->type('location', $payload->location)
                ->type('summary', $payload->summary)
                ->date('started_at', $payload->started_at)
                ->date('finished_at', $payload->finished_at)
                ->push('update');

            $browser->assertRouteIs('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee('The workplace has been updated');

            $browser->assertSee($payload->role)
                ->assertSee($payload->employer)
                ->assertSee($payload->location)
                ->assertSee($payload->started_at->date())
                ->assertSee($payload->finished_at->date());
        });
    }

    /** @test */
    public function a_user_can_delete_a_workplace() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $workplace = Workplace::factory()
                ->belongsTo($user)
                ->create();

            $browser->loginAs($user)
                ->visitRoute('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee($workplace->role)
                ->assertSee($workplace->employer)
                ->assertSee($workplace->location)
                ->assertSee($workplace->started_at->date())
                ->assertSee($workplace->finished_at->date());

            $browser->context("workplaces-{$workplace->id}", "workplaces-{$workplace->id}-delete");

            $browser->assertRouteIs('workplaces')
                ->assertTitle('Workplaces')
                ->assertSee('Workplaces');

            $browser->assertSee('The workplace has been deleted');

            $browser->assertDontSee($workplace->role)
                ->assertDontSee($workplace->employer)
                ->assertDontSee($workplace->location)
                ->assertDontSee($workplace->started_at->date())
                ->assertDontSee($workplace->finished_at->date());
        });
    }
}
