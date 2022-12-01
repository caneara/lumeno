<?php

namespace Tests\Acceptance\Organization;

use App\Models\User;
use App\Models\Member;
use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Collections\MemberRoleCollection;

class MemberTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_members_page() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $browser->loginAs($user)
                ->visitRoute('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee($user->name)
                ->assertSee($user->email)
                ->assertSee(Str::upper(MemberRoleCollection::find($user->member->role)->name));

            $browser->assertSee('1 team member');
        });
    }

    /** @test */
    public function a_user_can_store_a_member_that_has_an_account() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user_1 = User::factory()->create();
            $user_2 = User::factory()->create();

            Member::factory()
                ->belongsTo($organization, $user_1)
                ->create(['role' => Member::ROLE_MANAGER]);

            $browser->loginAs($user_1)
                ->visitRoute('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee($user_1->email)
                ->assertDontSee($user_2->email);

            $browser->action('create-member');

            $browser->assertSee('Add a new member');

            $browser->type('email', $user_2->email)
                ->card('role', Member::ROLE_ASSOCIATE)
                ->push('create');

            $browser->assertRouteIs('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee('The member has been created');

            $browser->assertSee($user_1->email)
                ->assertSee($user_2->email);
        });
    }

    /** @test */
    public function a_user_can_store_a_member_that_does_not_have_an_account() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user = User::factory()->create();

            Member::factory()
                ->belongsTo($organization, $user)
                ->create(['role' => Member::ROLE_MANAGER]);

            $browser->loginAs($user)
                ->visitRoute('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee($user->email);

            $browser->action('create-member');

            $browser->assertSee('Add a new member');

            $browser->type('email', 'test@example.com')
                ->card('role', Member::ROLE_ASSOCIATE)
                ->push('create');

            $browser->assertRouteIs('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee('The user has been invited to join');

            $browser->assertSee($user->email)
                ->assertDontSee('test@example.com');
        });
    }

    /** @test */
    public function a_user_can_update_a_member() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user_1 = User::factory()->create();
            $user_2 = User::factory()->create();

            $member_1 = Member::factory()
                ->belongsTo($organization, $user_1)
                ->create(['role' => Member::ROLE_MANAGER]);

            $member_2 = Member::factory()
                ->belongsTo($organization, $user_2)
                ->create(['role' => Member::ROLE_MANAGER]);

            $browser->loginAs($user_1)
                ->visitRoute('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee(Str::upper('Manager'))
                ->assertDontSee(Str::upper('Associate'));

            $browser->context("members-{$member_2->id}", "members-{$member_2->id}-edit");

            $browser->assertSee("Change member's role");

            $browser->card('role', Member::ROLE_ASSOCIATE)
                ->push('update');

            $browser->assertRouteIs('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee('The member has been updated');

            $browser->assertSee(Str::upper('Manager'))
                ->assertSee(Str::upper('Associate'));
        });
    }

    /** @test */
    public function a_user_can_delete_a_member() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription()->create();

            $user_1 = User::factory()->create();
            $user_2 = User::factory()->create();

            $member_1 = Member::factory()
                ->belongsTo($organization, $user_1)
                ->create();

            $member_2 = Member::factory()
                ->belongsTo($organization, $user_2)
                ->create();

            $browser->loginAs($user_1)
                ->visitRoute('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee($user_1->email)
                ->assertSee($user_2->email);

            $browser->context("members-{$member_2->id}", "members-{$member_2->id}-delete")
                ->confirm();

            $browser->assertRouteIs('members')
                ->assertTitle('Members')
                ->assertSee('Members');

            $browser->assertSee('The member has been deleted');

            $browser->assertSee($user_1->email)
                ->assertDontSee($user_2->email);
        });
    }
}
