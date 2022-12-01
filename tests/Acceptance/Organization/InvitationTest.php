<?php

namespace Tests\Acceptance\Organization;

use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use Tests\Workshops\VacancyWorkshop;
use App\Collections\CurrencyCollection;
use App\Collections\WorkCommitmentCollection;

class InvitationTest extends ClientTest
{
    /** @test */
    public function a_user_can_send_an_invitation() : void
    {
        $this->browse(function(Browser $browser) {
            $workshop = VacancyWorkshop::build();

            $browser->loginAs($workshop->user_2)
                ->visitRoute('vacancies.show', ['vacancy' => $workshop->vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Search Results');

            $browser->assertSee($workshop->user_1->name)
                ->assertSee($workshop->user_1->area)
                ->assertSee('63 KM')
                ->assertSee(Str::upper('Not Invited'));

            $browser->assertSee('0 invitations sent');

            $browser->context("users-{$workshop->user_1->id}", "users-{$workshop->user_1->id}-invitation")
                ->confirm();

            $browser->assertRouteIs('vacancies.show', ['vacancy' => $workshop->vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Search Results');

            $browser->assertSee('The user or users have been invited');

            $browser->assertSee($workshop->user_1->name)
                ->assertSee($workshop->user_1->area)
                ->assertSee('63 KM')
                ->assertSee(Str::upper('Invited'));

            $browser->assertSee($workshop->vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($workshop->vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($workshop->vacancy->currency)->code)
                ->assertSee(number_format($workshop->vacancy->remuneration));

            $browser->assertSee('1 invitation sent');
        });
    }

    /** @test */
    public function a_user_can_send_invitations_in_bulk() : void
    {
        $this->browse(function(Browser $browser) {
            $workshop = VacancyWorkshop::build();

            $browser->loginAs($workshop->user_2)
                ->visitRoute('vacancies.show', ['vacancy' => $workshop->vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Search Results');

            $browser->assertSee($workshop->user_1->name)
                ->assertSee($workshop->user_1->area)
                ->assertSee('63 KM')
                ->assertSee(Str::upper('Not Invited'));

            $browser->assertSee('0 invitations sent');

            $browser->action('send-invitations');

            $browser->assertSee('Send many invitations');

            $browser->type('limit', 5)
                ->push('send')
                ->confirm();

            $browser->assertRouteIs('vacancies.show', ['vacancy' => $workshop->vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Search Results');

            $browser->assertSee('The user or users have been invited');

            $browser->assertSee($workshop->user_1->name)
                ->assertSee($workshop->user_1->area)
                ->assertSee('63 KM')
                ->assertSee(Str::upper('Invited'));

            $browser->assertSee($workshop->vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($workshop->vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($workshop->vacancy->currency)->code)
                ->assertSee(number_format($workshop->vacancy->remuneration));

            $browser->assertSee('1 invitation sent');
        });
    }
}
