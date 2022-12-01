<?php

namespace Tests\Integration\Organization;

use App\Models\User;
use App\Models\Member;
use App\Types\ServerTest;
use App\Models\Organization;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RegisterAndEnlistNotification;

class MemberTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_members_page() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $this->actingAs($user)
            ->get(route('members'))
            ->assertSuccessful()
            ->assertPage('members.index');
    }

    /** @test */
    public function a_user_can_store_a_member_that_has_an_account() : void
    {
        Notification::fake();

        $organization = Organization::factory()->hasSubscription()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        Member::factory()
            ->belongsTo($organization, $user_1)
            ->create(['role' => Member::ROLE_MANAGER]);

        $payload = [
            'email' => $user_2->email,
            'role'  => Member::ROLE_ASSOCIATE,
        ];

        $this->actingAs($user_1)
            ->postJson(route('members.store'), $payload)
            ->assertRedirect(route('members'))
            ->assertNotification('The member has been created');

        $this->assertCount(2, Member::get());

        $this->assertTrue(Member::get()[0]->user->is($user_1));
        $this->assertTrue(Member::get()[1]->user->is($user_2));

        $this->assertEquals(Member::ROLE_MANAGER, Member::get()[0]->role);
        $this->assertEquals(Member::ROLE_ASSOCIATE, Member::get()[1]->role);

        Notification::assertNothingSent();
    }

    /** @test */
    public function a_user_can_store_a_member_that_does_not_have_an_account() : void
    {
        Notification::fake();

        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()->create();

        Member::factory()
            ->belongsTo($organization, $user)
            ->create(['role' => Member::ROLE_MANAGER]);

        $payload = [
            'email' => 'test@example.com',
            'role'  => Member::ROLE_ASSOCIATE,
        ];

        $this->actingAs($user)
            ->postJson(route('members.store'), $payload)
            ->assertRedirect(route('members'))
            ->assertNotification('The user has been invited to join');

        $this->assertCount(1, Member::get());

        $this->assertTrue(Member::first()->user->is($user));

        $payload = [
            'organization' => $organization->id,
            'role'         => Member::ROLE_ASSOCIATE,
        ];

        Notification::assertSentOnDemand(
            RegisterAndEnlistNotification::class,
            function($notification, $channels, $notifiable) use ($organization, $payload) {
                return $payload === decrypt($notification->payload) &&
                    $organization->name === $notification->organization &&
                    'test@example.com' === $notifiable->routes['mail'];
            }
        );
    }

    /** @test */
    public function a_user_cannot_store_a_member_if_the_target_user_is_already_a_member() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        Member::factory()
            ->belongsTo($organization, $user_1)
            ->create();

        Member::factory()
            ->belongsTo($organization, $user_2)
            ->create();

        $payload = [
            'email' => $user_2->email,
            'role'  => Member::ROLE_ASSOCIATE,
        ];

        $this->actingAs($user_1)
            ->postJson(route('members.store'), $payload)
            ->assertInvalid(['email' => 'The user is already a member of an organization']);
    }

    /** @test */
    public function a_user_can_update_a_member() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $member_1 = Member::factory()
            ->belongsTo($organization, $user_1)
            ->create(['role' => Member::ROLE_MANAGER]);

        $member_2 = Member::factory()
            ->belongsTo($organization, $user_2)
            ->create(['role' => Member::ROLE_MANAGER]);

        $this->actingAs($user_1)
            ->patchJson(route('members.update', ['member' => $member_2]), ['role' => Member::ROLE_ASSOCIATE])
            ->assertRedirect(route('members'))
            ->assertNotification('The member has been updated');

        $this->assertEquals(Member::ROLE_ASSOCIATE, $member_2->fresh()->role);
    }

    /** @test */
    public function a_user_cannot_update_their_own_membership() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()->create();

        $member = Member::factory()
            ->belongsTo($organization, $user)
            ->create(['role' => Member::ROLE_MANAGER]);

        $this->actingAs($user)
            ->patchJson(route('members.update', ['member' => $member]), ['role' => Member::ROLE_ASSOCIATE])
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_delete_a_member() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $member_1 = Member::factory()
            ->belongsTo($organization, $user_1)
            ->create();

        $member_2 = Member::factory()
            ->belongsTo($organization, $user_2)
            ->create();

        $this->actingAs($user_1)
            ->deleteJson(route('members.delete', ['member' => $member_2]))
            ->assertRedirect(route('members'))
            ->assertNotification('The member has been deleted');

        $this->assertCount(1, Member::get());

        $this->assertTrue(Member::first()->is($member_1));
    }

    /** @test */
    public function a_user_cannot_delete_their_own_membership() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()->create();

        $member = Member::factory()
            ->belongsTo($organization, $user)
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('members.delete', ['member' => $member]))
            ->assertForbidden();
    }
}
