<?php

namespace Tests\Integration\Organization;

use App\Models\User;
use App\Models\Member;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Invitation;
use App\Models\Requirement;
use App\Models\Organization;
use App\Models\Subscription;

class OrganizationTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_organization_page() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $this->actingAs($user)
            ->get(route('organization'))
            ->assertSuccessful()
            ->assertPage('organization.view.index');
    }

    /** @test */
    public function a_user_can_create_an_organization() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('organization.create'))
            ->assertSuccessful()
            ->assertPage('organization.create.index');
    }

    /** @test */
    public function a_user_can_store_an_organization() : void
    {
        $user = User::factory()->create();

        $payload = Organization::factory()->make();

        $this->actingAs($user)
            ->postJson(route('organization.store'), $payload->toArray())
            ->assertRedirect(route('spark.portal', ['type' => 'organization']));

        $this->assertCount(1, Member::get());
        $this->assertCount(1, Organization::get());

        $this->assertTrue(Member::first()->user->is($user));
        $this->assertTrue(Member::first()->organization->is(Organization::first()));

        $this->assertEquals(Member::ROLE_MANAGER, Member::first()->role);
        $this->assertEquals($payload->name, Organization::first()->name);
        $this->assertEquals($payload->email, Organization::first()->email);
        $this->assertTrue(Organization::first()->phone->is($payload->phone));
        $this->assertEquals($payload->website, Organization::first()->website);
    }

    /** @test */
    public function a_user_cannot_store_an_organization_if_they_are_already_a_member_of_an_organization() : void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $payload = Organization::factory()->make();

        $this->actingAs($user)
            ->postJson(route('organization.store'), $payload->toArray())
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_update_an_organization() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $payload = Organization::factory()->make();

        $this->actingAs($user)
            ->patchJson(route('organization.update'), $payload->toArray())
            ->assertRedirect(route('organization'))
            ->assertNotification('The organization has been updated');

        $this->assertEquals($payload['name'], $organization->fresh()->name);
        $this->assertEquals($payload['email'], $organization->fresh()->email);
        $this->assertTrue($organization->fresh()->phone->is($payload['phone']));
        $this->assertEquals($payload['website'], $organization->fresh()->website);
    }

    /** @test */
    public function a_user_can_delete_an_organization() : void
    {
        $organization_1 = Organization::factory()->hasSubscription()->create();
        $organization_2 = Organization::factory()->hasSubscription()->create();

        $user_1 = User::factory()
            ->with(Member::class, [$organization_1])
            ->create();

        $user_2 = User::factory()
            ->with(Member::class, [$organization_2])
            ->create();

        $vacancy_1 = Vacancy::factory()
            ->belongsTo($organization_1)
            ->with(Requirement::class, [$organization_1])
            ->with(Invitation::class, [$organization_1, $user_1])
            ->create();

        $vacancy_2 = Vacancy::factory()
            ->belongsTo($organization_2)
            ->with(Requirement::class, [$organization_2])
            ->with(Invitation::class, [$organization_2, $user_2])
            ->create();

        $this->actingAs($user_1)
            ->deleteJson(route('organization.delete'))
            ->assertRedirect(route('dashboard.user'))
            ->assertNotification('The organization has been deleted');

        $this->assertCount(1, Member::get());
        $this->assertCount(1, Vacancy::get());
        $this->assertCount(1, Invitation::get());
        $this->assertCount(1, Requirement::get());
        $this->assertCount(1, Subscription::get());
        $this->assertCount(1, Organization::get());

        $this->assertTrue(Vacancy::first()->is($vacancy_2));
        $this->assertTrue(Organization::first()->is($organization_2));
        $this->assertTrue(Member::first()->is($organization_2->members()->first()));
        $this->assertTrue(Subscription::first()->is($organization_2->subscription()));
        $this->assertTrue(Invitation::first()->is($vacancy_2->invitations()->first()));
        $this->assertTrue(Requirement::first()->is($vacancy_2->requirements()->first()));

        $this->assertFalse($organization_1->subscribed());
        $this->assertTrue($organization_2->subscribed());
    }
}
