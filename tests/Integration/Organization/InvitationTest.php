<?php

namespace Tests\Integration\Organization;

use App\Types\ServerTest;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\Workshops\VacancyWorkshop;

class InvitationTest extends ServerTest
{
    /** @test */
    public function a_user_can_store_an_invitation_on_the_silver_plan() : void
    {
        $workshop = VacancyWorkshop::build();

        Subscription::first()->update([
            'paddle_plan' => config('spark.billables.organization.plans.0.monthly_id'),
        ]);

        $payload = [
            'vacancy' => $workshop->vacancy,
            'user'    => $workshop->user_1,
        ];

        $this->actingAs($workshop->user_2)
            ->from(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->postJson(route('invitations.store', $payload))
            ->assertRedirect(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->assertNotification('The user or users have been invited');

        $this->assertCount(1, Invitation::get());

        $this->assertNull(Invitation::first()->sent_at);
        $this->assertNull(Invitation::first()->sending_at);
        $this->assertTrue(Invitation::first()->user->is($workshop->user_1));
        $this->assertTrue(Invitation::first()->vacancy->is($workshop->vacancy));
        $this->assertTrue(Invitation::first()->organization->is($workshop->organization));

        Http::assertSent(function(Request $request) use ($workshop) {
            return Str::endsWith($request->url(), '/subscription/modifiers/create') &&
                $request['modifier_amount'] === "1.00" &&
                $request['modifier_recurring'] === false &&
                $request['modifier_description'] === "Vacancy #{$workshop->vacancy->id}" &&
                $request['subscription_id'] === $workshop->organization->subscription()->paddle_id;
        });
    }

    /** @test */
    public function a_user_can_store_an_invitation_on_the_gold_plan() : void
    {
        $workshop = VacancyWorkshop::build();

        Subscription::first()->update([
            'paddle_plan' => config('spark.billables.organization.plans.1.yearly_id'),
        ]);

        $payload = [
            'vacancy' => $workshop->vacancy,
            'user'    => $workshop->user_1,
        ];

        $this->actingAs($workshop->user_2)
            ->from(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->postJson(route('invitations.store', $payload))
            ->assertRedirect(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->assertNotification('The user or users have been invited');

        $this->assertCount(1, Invitation::get());

        $this->assertNull(Invitation::first()->sent_at);
        $this->assertNull(Invitation::first()->sending_at);
        $this->assertTrue(Invitation::first()->user->is($workshop->user_1));
        $this->assertTrue(Invitation::first()->vacancy->is($workshop->vacancy));
        $this->assertTrue(Invitation::first()->organization->is($workshop->organization));

        Http::assertSent(function(Request $request) use ($workshop) {
            return Str::endsWith($request->url(), '/subscription/modifiers/create') &&
                $request['modifier_amount'] === "0.75" &&
                $request['modifier_recurring'] === false &&
                $request['modifier_description'] === "Vacancy #{$workshop->vacancy->id}" &&
                $request['subscription_id'] === $workshop->organization->subscription()->paddle_id;
        });
    }

    /** @test */
    public function a_user_can_store_an_invitation_on_the_platinum_plan() : void
    {
        $workshop = VacancyWorkshop::build();

        Subscription::first()->update([
            'paddle_plan' => config('spark.billables.organization.plans.2.yearly_id'),
        ]);

        $payload = [
            'vacancy' => $workshop->vacancy,
            'user'    => $workshop->user_1,
        ];

        $this->actingAs($workshop->user_2)
            ->from(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->postJson(route('invitations.store', $payload))
            ->assertRedirect(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->assertNotification('The user or users have been invited');

        $this->assertCount(1, Invitation::get());

        $this->assertNull(Invitation::first()->sent_at);
        $this->assertNull(Invitation::first()->sending_at);
        $this->assertTrue(Invitation::first()->user->is($workshop->user_1));
        $this->assertTrue(Invitation::first()->vacancy->is($workshop->vacancy));
        $this->assertTrue(Invitation::first()->organization->is($workshop->organization));

        Http::assertSent(function(Request $request) use ($workshop) {
            return Str::endsWith($request->url(), '/subscription/modifiers/create') &&
                $request['modifier_amount'] === "0.50" &&
                $request['modifier_recurring'] === false &&
                $request['modifier_description'] === "Vacancy #{$workshop->vacancy->id}" &&
                $request['subscription_id'] === $workshop->organization->subscription()->paddle_id;
        });
    }

    /** @test */
    public function a_user_cannot_store_an_invitation_if_the_user_has_already_been_invited() : void
    {
        $workshop = VacancyWorkshop::build();

        Invitation::factory()
            ->belongsTo($workshop->organization, $workshop->vacancy, $workshop->user_1)
            ->create();

        $payload = [
            'vacancy' => $workshop->vacancy,
            'user'    => $workshop->user_1,
        ];

        $this->actingAs($workshop->user_2)
            ->postJson(route('invitations.store', $payload))
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_send_invitations_in_bulk() : void
    {
        $workshop = VacancyWorkshop::build();

        VacancyWorkshop::resume($user = VacancyWorkshop::user());

        $this->actingAs($workshop->user_2)
            ->postJson(route('invitations.bulk', ['vacancy' => $workshop->vacancy]), ['limit' => 10])
            ->assertRedirect(route('vacancies.show', ['vacancy' => $workshop->vacancy]))
            ->assertNotification('The user or users have been invited');

        $this->assertCount(2, Invitation::get());

        $this->assertNull(Invitation::get()[0]->sent_at);
        $this->assertNull(Invitation::get()[0]->sending_at);
        $this->assertTrue(Invitation::get()[0]->user->is($user));
        $this->assertTrue(Invitation::get()[0]->vacancy->is($workshop->vacancy));
        $this->assertTrue(Invitation::get()[0]->organization->is($workshop->organization));

        $this->assertNull(Invitation::get()[1]->sent_at);
        $this->assertNull(Invitation::get()[1]->sending_at);
        $this->assertTrue(Invitation::get()[1]->user->is($workshop->user_1));
        $this->assertTrue(Invitation::get()[1]->vacancy->is($workshop->vacancy));
        $this->assertTrue(Invitation::get()[1]->organization->is($workshop->organization));

        Http::assertSent(function(Request $request) use ($workshop) {
            return Str::endsWith($request->url(), '/subscription/modifiers/create') &&
                $request['modifier_amount'] === "2.00" &&
                $request['modifier_recurring'] === false &&
                $request['modifier_description'] === "Vacancy #{$workshop->vacancy->id}" &&
                $request['subscription_id'] === $workshop->organization->subscription()->paddle_id;
        });
    }
}
