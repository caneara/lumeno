<?php

namespace Tests\Integration\Organization;

use App\Models\User;
use App\Models\Member;
use App\Models\Vacancy;
use App\Types\ServerTest;
use App\Models\Invitation;
use App\Models\Requirement;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Actions\Vacancy\ExportAction;
use App\Collections\CountryCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;

class VacancyTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_vacancies_page() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $this->actingAs($user)
            ->get(route('vacancies'))
            ->assertSuccessful()
            ->assertPage('vacancies.view.index');
    }

    /** @test */
    public function a_user_can_create_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $this->actingAs($user)
            ->get(route('vacancies.create'))
            ->assertSuccessful()
            ->assertPage('vacancies.create.index');
    }

    /** @test */
    public function a_user_can_edit_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $this->actingAs($user)
            ->get(route('vacancies.edit', ['vacancy' => $vacancy]))
            ->assertSuccessful()
            ->assertPage('vacancies.edit.index');
    }

    /** @test */
    public function a_user_can_export_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        Invitation::factory()
            ->belongsTo($organization, $vacancy, $user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route('vacancies.export', ['vacancy' => $vacancy]))
            ->assertDownload(Str::snake("{$vacancy->role}.csv"));

        $csv = $response->streamedContent();

        $this->assertTrue(Str::contains($csv, Arr::pluck(ExportAction::$fields, 'header')));
        $this->assertTrue(Str::contains($csv, $user->name));
        $this->assertTrue(Str::contains($csv, route('account.show', $user->handle)));
        $this->assertTrue(Str::contains($csv, CountryCollection::find($user->country)?->name));
        $this->assertTrue(Str::contains($csv, $user->area));
        $this->assertTrue(Str::contains($csv, TimeZoneCollection::find($user->time_zone)?->name));
        $this->assertTrue(Str::contains($csv, LanguageCollection::find($user->first_language)?->name));
        $this->assertTrue(Str::contains($csv, LanguageCollection::find($user->second_language)?->name));
        $this->assertTrue(Str::contains($csv, LanguageCollection::find($user->third_language)?->name));
        $this->assertTrue(Str::contains($csv, $user->website));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->github, 'https://github.com/XXX')));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->twitter, 'https://twitter.com/XXX')));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->linkedin, 'https://www.linkedin.com/in/XXX')));
        $this->assertTrue(Str::contains($csv, $user->discord));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->youtube, 'https://youtube.com/c/XXX')));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->facebook, 'https://www.facebook.com/XXX')));
        $this->assertTrue(Str::contains($csv, ExportAction::link($user->instagram, 'https://www.instagram.com/XXX')));
    }

    /** @test */
    public function a_user_can_show_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->with(Requirement::class, [$organization])
            ->create();

        $this->actingAs($user)
            ->get(route('vacancies.show', ['vacancy' => $vacancy]))
            ->assertSuccessful()
            ->assertPage('vacancies.show.index');
    }

    /** @test */
    public function a_user_cannot_show_a_vacancy_when_it_has_no_requirements() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $this->actingAs($user)
            ->getJson(route('vacancies.show', ['vacancy' => $vacancy]))
            ->assertForbidden()
            ->assertJsonFragment(['The vacancy must have at least one requirement']);
    }

    /** @test */
    public function a_user_can_store_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $payload = Vacancy::factory()
            ->belongsTo($organization)
            ->make([
                'commitment' => Vacancy::COMMITMENT_FULL_TIME,
                'months'     => null,
            ]);

        $this->actingAs($user)
            ->postJson(route('vacancies.store'), $payload->toArray())
            ->assertRedirect(route('vacancies.edit', ['vacancy' => Vacancy::first()]))
            ->assertNotification('The vacancy has been created');

        $this->assertCount(1, Vacancy::get());

        $this->assertTrue(Vacancy::first()->organization->is($organization));

        $this->assertEquals(Vacancy::first()->role, $payload->role);
        $this->assertEquals(Vacancy::first()->summary, $payload->summary);
        $this->assertEquals(Vacancy::first()->commitment, $payload->commitment);
        $this->assertEquals(Vacancy::first()->months, $payload->months);
        $this->assertEquals(Vacancy::first()->currency, $payload->currency);
        $this->assertEquals(Vacancy::first()->remuneration, $payload->remuneration);
        $this->assertEquals(Vacancy::first()->area, $payload->area);
        $this->assertEquals(Vacancy::first()->country, $payload->country);
        $this->assertEquals(Vacancy::first()->coordinates, $payload->coordinates);
        $this->assertEquals(Vacancy::first()->first_language, $payload->first_language);
        $this->assertEquals(Vacancy::first()->second_language, $payload->second_language);
        $this->assertEquals(Vacancy::first()->third_language, $payload->third_language);
        $this->assertEquals(Vacancy::first()->remote, $payload->remote);
        $this->assertEquals(Vacancy::first()->emigrate, $payload->emigrate);
        $this->assertEquals(Vacancy::first()->degree, $payload->degree);
        $this->assertEquals(Vacancy::first()->email, $payload->email);
        $this->assertTrue(Vacancy::first()->phone->is($payload->phone));
        $this->assertEquals(Vacancy::first()->website, $payload->website);
    }

    /** @test */
    public function a_user_can_update_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $payload = Vacancy::factory()
            ->belongsTo($organization)
            ->make([
                'commitment' => Vacancy::COMMITMENT_CONTRACT,
                'months'     => 6,
            ]);

        $this->actingAs($user)
            ->patchJson(route('vacancies.update', ['vacancy' => $vacancy]), $payload->toArray())
            ->assertRedirect(route('vacancies.edit', ['vacancy' => $vacancy]))
            ->assertNotification('The vacancy has been updated');

        $this->assertEquals($vacancy->fresh()->role, $payload->role);
        $this->assertEquals($vacancy->fresh()->summary, $payload->summary);
        $this->assertEquals($vacancy->fresh()->commitment, $payload->commitment);
        $this->assertEquals($vacancy->fresh()->months, $payload->months);
        $this->assertEquals($vacancy->fresh()->currency, $payload->currency);
        $this->assertEquals($vacancy->fresh()->remuneration, $payload->remuneration);
        $this->assertEquals($vacancy->fresh()->area, $payload->area);
        $this->assertEquals($vacancy->fresh()->country, $payload->country);
        $this->assertEquals($vacancy->fresh()->coordinates, $payload->coordinates);
        $this->assertEquals($vacancy->fresh()->first_language, $payload->first_language);
        $this->assertEquals($vacancy->fresh()->second_language, $payload->second_language);
        $this->assertEquals($vacancy->fresh()->third_language, $payload->third_language);
        $this->assertEquals($vacancy->fresh()->remote, $payload->remote);
        $this->assertEquals($vacancy->fresh()->emigrate, $payload->emigrate);
        $this->assertEquals($vacancy->fresh()->degree, $payload->degree);
        $this->assertEquals($vacancy->fresh()->email, $payload->email);
        $this->assertTrue($vacancy->fresh()->phone->is($payload->phone));
        $this->assertEquals($vacancy->fresh()->website, $payload->website);
    }

    /** @test */
    public function a_user_can_delete_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy_1 = Vacancy::factory()
            ->belongsTo($organization)
            ->with(Requirement::class, [$organization])
            ->create();

        $vacancy_2 = Vacancy::factory()
            ->belongsTo($organization)
            ->with(Requirement::class, [$organization])
            ->with(Invitation::class, [$organization, $user])
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('vacancies.delete', ['vacancy' => $vacancy_1]))
            ->assertRedirect(route('vacancies'))
            ->assertNotification('The vacancy has been deleted');

        $this->assertCount(1, Vacancy::get());
        $this->assertCount(1, Invitation::get());
        $this->assertCount(1, Requirement::get());

        $this->assertTrue(Vacancy::first()->is($vacancy_2));
        $this->assertTrue(Invitation::first()->is($vacancy_2->invitations->first()));
        $this->assertTrue(Requirement::first()->is($vacancy_2->requirements->first()));
    }

    /** @test */
    public function a_user_cannot_delete_a_vacancy_when_it_has_invitations() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->with(Requirement::class, [$organization])
            ->with(Invitation::class, [$organization, $user])
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('vacancies.delete', ['vacancy' => $vacancy]))
            ->assertForbidden();
    }

    /** @test */
    public function a_user_can_archive_a_vacancy() : void
    {
        $organization = Organization::factory()->hasSubscription()->create();

        $user = User::factory()
            ->with(Member::class, [$organization])
            ->create();

        $vacancy = Vacancy::factory()
            ->belongsTo($organization)
            ->create();

        $this->actingAs($user)
            ->patchJson(route('vacancies.archive', ['vacancy' => $vacancy]))
            ->assertRedirect(route('vacancies'))
            ->assertNotification('The vacancy has been archived');

        $this->assertEquals($vacancy->fresh()->archived_at, now());
    }
}
