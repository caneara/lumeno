<?php

namespace Tests\Acceptance\Organization;

use App\Models\User;
use App\Models\Member;
use App\Types\Browser;
use App\Models\Vacancy;
use App\Types\ClientTest;
use App\Models\Invitation;
use App\Models\Requirement;
use Illuminate\Support\Str;
use App\Models\Organization;
use Tests\Workshops\VacancyWorkshop;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Collections\WorkCommitmentCollection;

class VacancyTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_vacancies_page() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->with(Invitation::class, [$organization])
                ->create(['summary' => Str::random(50)]);

            $browser->loginAs($user)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee($vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($vacancy->currency)->code)
                ->assertSee(number_format($vacancy->remuneration))
                ->assertSee($vacancy->area)
                ->assertSee(CountryCollection::find($vacancy->country)->name)
                ->assertSee(LanguageCollection::list($vacancy))
                ->assertSee($vacancy->summary);

            $browser->assertSee('1 vacancy')
                ->assertSee(Str::upper('1 invitation sent'));
        });
    }

    /** @test */
    public function a_user_can_show_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $workshop = VacancyWorkshop::build();

            Invitation::factory()
                ->belongsTo($workshop->organization, $workshop->vacancy, $workshop->user_1)
                ->create();

            $browser->loginAs($workshop->user_2)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee($workshop->vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($workshop->vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($workshop->vacancy->currency)->code)
                ->assertSee(number_format($workshop->vacancy->remuneration))
                ->assertSee(CountryCollection::find($workshop->vacancy->country)->name)
                ->assertSee(LanguageCollection::list($workshop->vacancy))
                ->assertSee($workshop->vacancy->summary);

            $browser->assertSee('1 vacancy')
                ->assertSee(Str::upper('1 invitation sent'));

            $browser->context("vacancies-{$workshop->vacancy->id}", "vacancies-{$workshop->vacancy->id}-show");

            $browser->assertRouteIs('vacancies.show', ['vacancy' => $workshop->vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Search Results');

            $browser->assertSee($workshop->user_1->name)
                ->assertSee(Str::upper('Invited'))
                ->assertSee("{$workshop->user_1->area} - 63 KM away")
                ->assertSee(CountryCollection::find($workshop->user_1->country)->name)
                ->assertSee(TimeZoneCollection::find($workshop->user_1->time_zone)->short)
                ->assertSee(LanguageCollection::list($workshop->user_1))
                ->assertSee($workshop->user_1->statement);

            $browser->assertSee($workshop->vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($workshop->vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($workshop->vacancy->currency)->code)
                ->assertSee(number_format($workshop->vacancy->remuneration));

            $browser->assertSee('1 invitation sent');
        });
    }

    /** @test */
    public function a_user_can_export_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $workshop = VacancyWorkshop::build();

            Invitation::factory()
                ->belongsTo($workshop->organization, $workshop->vacancy, $workshop->user_1)
                ->create();

            $browser->loginAs($workshop->user_2)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee('1 vacancy')
                ->assertSee(Str::upper('1 invitation sent'));

            $browser->context("vacancies-{$workshop->vacancy->id}", "vacancies-{$workshop->vacancy->id}-export");

            $browser->assertDownloaded(Str::snake("{$workshop->vacancy->role}.csv"));
        });
    }

    /** @test */
    public function a_user_can_store_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->make([
                    'commitment' => Vacancy::COMMITMENT_FULL_TIME,
                    'months'     => null,
                    'emigrate'   => true,
                    'remote'     => true,
                    'degree'     => true,
                ]);

            $browser->loginAs($user)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee('0 vacancies');

            $browser->action('create-vacancy');

            $browser->assertRouteIs('vacancies.create')
                ->assertTitle('Vacancies')
                ->assertSee('Create Vacancy');

            $browser->assertInputValue('email', $organization->email)
                ->assertInputValue('phone', $organization->phone)
                ->assertInputValue('website', $organization->website);

            $browser->type('role', $vacancy->role)
                ->type('summary', $vacancy->summary)
                ->select('commitment', $vacancy->commitment)
                ->select('currency', $vacancy->currency)
                ->type('remuneration', $vacancy->remuneration)
                ->type('area', $vacancy->area)
                ->select('country', $vacancy->country)
                ->type('coordinates', $vacancy->coordinates)
                ->check('emigrate', $vacancy->emigrate)
                ->select('first_language', $vacancy->first_language)
                ->select('second_language', $vacancy->second_language)
                ->select('third_language', $vacancy->third_language)
                ->check('remote', $vacancy->remote)
                ->check('degree', $vacancy->degree)
                ->type('email', $vacancy->email)
                ->type('phone', $vacancy->phone)
                ->type('website', $vacancy->website)
                ->push('continue');

            $browser->assertSee('Keeping the platform positive');

            $browser->check('accept')
                ->push('create');

            $browser->assertRouteIs('vacancies.edit', ['vacancy' => Vacancy::first()])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->assertSee('The vacancy has been created');

            $browser->assertInputValue('role', $vacancy->role)
                ->assertInputValue('summary', $vacancy->summary)
                ->assertSelected('commitment', $vacancy->commitment)
                ->assertSelected('currency', $vacancy->currency)
                ->assertInputValue('remuneration', $vacancy->remuneration)
                ->assertInputValue('area', $vacancy->area)
                ->assertSelected('country', $vacancy->country)
                ->assertInputValue('coordinates', $vacancy->coordinates)
                ->assertSelected('first_language', $vacancy->first_language)
                ->assertSelected('second_language', $vacancy->second_language)
                ->assertSelected('third_language', $vacancy->third_language)
                ->assertChecked('emigrate', $vacancy->emigrate)
                ->assertChecked('remote', $vacancy->remote)
                ->assertChecked('degree', $vacancy->degree)
                ->assertInputValue('email', $vacancy->email)
                ->assertInputValue('phone', $vacancy->phone)
                ->assertInputValue('website', $vacancy->website);

            $browser->assertSee("You haven't added any requirements yet");

            $browser->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee('1 vacancy');
        });
    }

    /** @test */
    public function a_user_can_update_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->create([
                    'commitment' => Vacancy::COMMITMENT_FULL_TIME,
                    'emigrate'   => false,
                    'remote'     => false,
                    'degree'     => false,
                ]);

            $payload = Vacancy::factory()
                ->belongsTo($organization)
                ->make([
                    'commitment' => Vacancy::COMMITMENT_CONTRACT,
                    'months'     => 6,
                    'emigrate'   => true,
                    'remote'     => true,
                    'degree'     => true,
                ]);

            $browser->loginAs($user)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee($vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($vacancy->currency)->code)
                ->assertSee(number_format($vacancy->remuneration))
                ->assertSee(CountryCollection::find($vacancy->country)->name)
                ->assertSee(LanguageCollection::list($vacancy));

            $browser->assertSee('1 vacancy');

            $browser->context("vacancies-{$vacancy->id}", "vacancies-{$vacancy->id}-edit");

            $browser->assertRouteIs('vacancies.edit', ['vacancy' => $vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->assertInputValue('role', $vacancy->role)
                ->assertInputValue('summary', $vacancy->summary)
                ->assertSelected('commitment', $vacancy->commitment)
                ->assertSelected('currency', $vacancy->currency)
                ->assertInputValue('remuneration', $vacancy->remuneration)
                ->assertInputValue('area', $vacancy->area)
                ->assertSelected('country', $vacancy->country)
                ->assertInputValue('coordinates', $vacancy->coordinates)
                ->assertSelected('first_language', $vacancy->first_language)
                ->assertSelected('second_language', $vacancy->second_language)
                ->assertSelected('third_language', $vacancy->third_language)
                ->assertChecked('emigrate', $vacancy->emigrate)
                ->assertChecked('remote', $vacancy->remote)
                ->assertChecked('degree', $vacancy->degree)
                ->assertInputValue('email', $vacancy->email)
                ->assertInputValue('phone', $vacancy->phone)
                ->assertInputValue('website', $vacancy->website);

            $browser->assertSee("You haven't added any requirements yet");

            $browser->type('role', $payload->role)
                ->type('summary', $payload->summary)
                ->select('commitment', $payload->commitment)
                ->type('months', $payload->months)
                ->select('currency', $payload->currency)
                ->type('remuneration', $payload->remuneration)
                ->type('area', $payload->area)
                ->select('country', $payload->country)
                ->type('coordinates', $payload->coordinates)
                ->check('emigrate', $payload->emigrate)
                ->select('first_language', $payload->first_language)
                ->select('second_language', $payload->second_language)
                ->select('third_language', $payload->third_language)
                ->check('remote', $payload->remote)
                ->check('degree', $payload->degree)
                ->type('email', $payload->email)
                ->type('phone', $payload->phone)
                ->type('website', $payload->website)
                ->push('save');

            $browser->assertRouteIs('vacancies.edit', ['vacancy' => $vacancy])
                ->assertTitle('Vacancies')
                ->assertSee('Edit Vacancy');

            $browser->assertSee('The vacancy has been updated');

            $browser->assertInputValue('role', $payload->role)
                ->assertInputValue('summary', $payload->summary)
                ->assertSelected('commitment', $payload->commitment)
                ->assertSelected('currency', $payload->currency)
                ->assertInputValue('months', $payload->months)
                ->assertInputValue('remuneration', $payload->remuneration)
                ->assertInputValue('area', $payload->area)
                ->assertSelected('country', $payload->country)
                ->assertInputValue('coordinates', $payload->coordinates)
                ->assertSelected('first_language', $payload->first_language)
                ->assertSelected('second_language', $payload->second_language)
                ->assertSelected('third_language', $payload->third_language)
                ->assertChecked('emigrate', $payload->emigrate)
                ->assertChecked('remote', $payload->remote)
                ->assertChecked('degree', $payload->degree)
                ->assertInputValue('email', $payload->email)
                ->assertInputValue('phone', $payload->phone)
                ->assertInputValue('website', $payload->website);

            $browser->assertSee("You haven't added any requirements yet");
        });
    }

    /** @test */
    public function a_user_can_delete_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->with(Requirement::class, [$organization])
                ->create(['summary' => Str::random(50)]);

            $browser->loginAs($user)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee($vacancy->role)
                ->assertSee(WorkCommitmentCollection::find($vacancy->commitment)->name)
                ->assertSee(CurrencyCollection::find($vacancy->currency)->code)
                ->assertSee(number_format($vacancy->remuneration))
                ->assertSee($vacancy->area)
                ->assertSee(CountryCollection::find($vacancy->country)->name)
                ->assertSee(LanguageCollection::list($vacancy))
                ->assertSee($vacancy->summary);

            $browser->assertSee('1 vacancy');

            $browser->context("vacancies-{$vacancy->id}", "vacancies-{$vacancy->id}-delete")
                ->confirm();

            $browser->assertRouteIs('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee('The vacancy has been deleted');

            $browser->assertDontSee($vacancy->role)
                ->assertDontSee(WorkCommitmentCollection::find($vacancy->commitment)->name)
                ->assertDontSee(CurrencyCollection::find($vacancy->currency)->code)
                ->assertDontSee(number_format($vacancy->remuneration))
                ->assertDontSee($vacancy->area)
                ->assertDontSee(CountryCollection::find($vacancy->country)->name)
                ->assertDontSee(LanguageCollection::list($vacancy))
                ->assertDontSee($vacancy->summary);

            $browser->assertSee('0 vacancies');
        });
    }

    /** @test */
    public function a_user_can_archive_a_vacancy() : void
    {
        $this->browse(function(Browser $browser) {
            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(Member::class, [$organization])
                ->create();

            $vacancy = Vacancy::factory()
                ->belongsTo($organization)
                ->with(Requirement::class, [$organization])
                ->create(['summary' => Str::random(50)]);

            $browser->loginAs($user)
                ->visitRoute('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee($vacancy->role)
                ->assertDontSee(Str::upper('Archived'));

            $browser->context("vacancies-{$vacancy->id}", "vacancies-{$vacancy->id}-archive")
                ->confirm();

            $browser->assertRouteIs('vacancies')
                ->assertTitle('Vacancies')
                ->assertSee('Vacancies');

            $browser->assertSee('The vacancy has been archived');

            $browser->assertSee($vacancy->role)
                ->assertSee(Str::upper('Archived'));
        });
    }
}
