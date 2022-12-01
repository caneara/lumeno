<?php

namespace Tests\Unit\Billing;

use Spark\Spark;
use App\Models\User;
use App\Models\Member;
use App\Types\ServerTest;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrganizationTest extends ServerTest
{
    /** @test */
    public function it_can_resolve_a_billable_organization() : void
    {
        $user = User::factory()
            ->hasMember()
            ->create();

        Auth::login($user);

        $billable = Spark::getFacadeRoot()->billableResolvingCallbacks['organization'](request());

        $this->assertTrue($user->member->organization->is($billable));
    }

    /** @test */
    public function it_knows_that_a_user_with_the_manager_role_is_authorized_to_view_the_billing_portal() : void
    {
        $organization_1 = Organization::factory()->create();
        $organization_2 = Organization::factory()->create();

        $user = User::factory()
            ->with(Member::class, $organization_1, ['role' => Member::ROLE_MANAGER])
            ->create();

        Auth::login($user);

        $this->assertTrue(Spark::isAuthorizedToViewBillingPortal($organization_1, request()));
        $this->assertFalse(Spark::isAuthorizedToViewBillingPortal($organization_2, request()));
    }

    /** @test */
    public function it_knows_that_a_user_with_the_associate_role_is_not_authorized_to_view_the_billing_portal() : void
    {
        $organization_1 = Organization::factory()->create();
        $organization_2 = Organization::factory()->create();

        $user = User::factory()
            ->with(Member::class, $organization_1, ['role' => Member::ROLE_ASSOCIATE])
            ->create();

        Auth::login($user);

        $this->expectException(HttpException::class);

        $this->assertFalse(Spark::isAuthorizedToViewBillingPortal($organization_1, request()));
        $this->assertFalse(Spark::isAuthorizedToViewBillingPortal($organization_2, request()));
    }

    /** @test */
    public function it_knows_that_a_user_without_a_role_is_not_authorized_to_view_the_billing_portal() : void
    {
        $organization = Organization::factory()->create();

        $user = User::factory()->create();

        Auth::login($user);

        $this->assertFalse(Spark::isAuthorizedToViewBillingPortal($organization, request()));
    }
}
