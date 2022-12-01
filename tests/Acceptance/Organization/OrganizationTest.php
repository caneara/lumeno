<?php

namespace Tests\Acceptance\Organization;

use App\Models\User;
use App\Models\Member;
use App\Types\Browser;
use App\Models\Vacancy;
use App\Types\ClientTest;
use App\Models\Invitation;
use App\Models\Organization;

class OrganizationTest extends ClientTest
{
    /** @test */
    public function a_user_can_store_an_organization() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $payload = Organization::factory()->make();

            $browser->loginAs($user)
                ->visitRoute('organization.create')
                ->assertTitle('Organization')
                ->assertSee('Create an organization');

            $browser->type('name', $payload->name)
                ->type('email', $payload->email)
                ->type('phone', $payload->phone)
                ->type('website', $payload->website)
                ->push('create');

            $browser->assertRouteIs('spark.portal', ['type' => 'organization']);
        });
    }

    /** @test */
    public function a_user_can_update_their_organization() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            Vacancy::factory()
                ->belongsTo($organization)
                ->with(Invitation::class, [$organization])
                ->create();

            $payload = Organization::factory()->make();

            $browser->loginAs($user)
                ->visitRoute('organization')
                ->assertTitle('Organization')
                ->assertSee('Organization');

            $browser->assertSee("Joined {$organization->created_at->date()}");

            $browser->assertSee('Platinum Plan')
                ->assertSee('Due ' . now()->date())
                ->assertSee('1 invitation sent');

            $browser->assertInputValue('name', $organization->name)
                ->assertInputValue('email', $organization->email)
                ->assertInputValue('phone', $organization->phone)
                ->assertInputValue('website', $organization->website);

            $browser->type('name', $payload->name)
                ->type('email', $payload->email)
                ->type('phone', $payload->phone)
                ->type('website', $payload->website)
                ->push('update');

            $browser->assertRouteIs('organization')
                ->assertTitle('Organization')
                ->assertSee('Organization');

            $browser->assertSee('The organization has been updated');

            $browser->assertInputValue('name', $payload->name)
                ->assertInputValue('email', $payload->email)
                ->assertInputValue('phone', $payload->phone)
                ->assertInputValue('website', $payload->website);
        });
    }

    /** @test */
    public function a_user_can_delete_their_organization() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $browser->loginAs($user)
                ->visitRoute('organization')
                ->assertTitle('Organization')
                ->assertSee('Organization');

            $browser->action('delete-organization');

            $browser->assertSee('Delete your organization');

            $browser->type('organization', $organization->name)
                ->push('delete');

            $browser->assertRouteIs('dashboard.user')
                ->assertTitle('Dashboard')
                ->assertSee('dashboard');

            $browser->assertSee('The organization has been deleted');
        });
    }
}
