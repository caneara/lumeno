<?php

namespace Tests\Acceptance\User;

use App\Models\Tool;
use App\Models\User;
use App\Models\Skill;
use App\Models\Member;
use App\Models\School;
use App\Types\Browser;
use App\Models\Article;
use App\Models\Project;
use App\Models\Category;
use App\Models\Workplace;
use App\Types\ClientTest;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Collections\CountryCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Collections\ProjectTypeCollection;
use App\Collections\ToolCategoryCollection;
use App\Collections\EducationalQualificationCollection;

class AccountTest extends ClientTest
{
    /** @test */
    public function a_user_can_show_an_account_and_see_everything_when_they_are_part_of_an_organization() : void
    {
        $this->browse(function(Browser $browser) {
            ToolCategoryCollection::seed();

            $organization = Organization::factory()->hasSubscription('Silver')->create();

            $user = User::factory()
                ->with(3, School::class)
                ->with(3, Project::class)
                ->with(3, Article::class)
                ->with(3, Workplace::class)
                ->with(Member::class, [$organization])
                ->create([
                    'statement' => Str::random(50),
                    'website'   => 'https://www.example.com',
                ]);

            Tool::factory()
                ->belongsTo(Category::first())
                ->with(3, Skill::class, [$user])
                ->create();

            $browser->loginAs($user)
                ->visitRoute('account.show', ['user' => $user->handle])
                ->assertTitle($user->name)
                ->assertSee($user->name);

            $browser->assertSee("@{$user->handle}")
                ->assertSee($user->area)
                ->assertSee(CountryCollection::find($user->country)->name)
                ->assertSee(TimeZoneCollection::find($user->time_zone)->short)
                ->assertSee(LanguageCollection::list($user))
                ->assertSee('example.com')
                ->assertSee($user->github)
                ->assertSee($user->twitter)
                ->assertSee($user->linkedin)
                ->assertSee($user->discord)
                ->assertSee($user->youtube)
                ->assertSee($user->facebook)
                ->assertSee($user->instagram);

            $browser->assertSee($user->statement);

            $browser->click('@set-tab-skills');

            Skill::get()->each(function($skill) use ($browser) {
                $browser->assertSee($skill->tool->name)
                    ->assertSee(Str::upper($skill->years . ' ' . Str::plural('year', $skill->years)))
                    ->assertSee($skill->summary);
            });

            $browser->click('@set-tab-employment');

            Workplace::get()->each(function($workplace) use ($browser) {
                $browser->assertSee($workplace->role)
                    ->assertSee($workplace->started_at->date())
                    ->assertSee($workplace->finished_at->date())
                    ->assertSee($workplace->employer)
                    ->assertSee($workplace->location)
                    ->assertSee($workplace->summary);
            });

            $browser->click('@set-tab-education');

            School::get()->each(function($school) use ($browser) {
                $browser->assertSee($school->course)
                    ->assertSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                    ->assertSee($school->started_at->date())
                    ->assertSee($school->finished_at->date())
                    ->assertSee($school->name)
                    ->assertSee($school->location);
            });

            $browser->click('@set-tab-projects');

            Project::get()->each(function($project) use ($browser) {
                $browser->assertSee($project->title)
                    ->assertSee(ProjectTypeCollection::find($project->type)->name)
                    ->assertSee($project->summary)
                    ->assertSee(Str::upper('Images'))
                    ->assertSee(Str::upper($project->first_tag))
                    ->assertSee(Str::upper($project->second_tag))
                    ->assertSee(Str::upper($project->third_tag))
                    ->assertSee(Str::upper($project->fourth_tag));
            });

            $browser->click('@set-tab-articles');

            Article::get()->each(function($article) use ($browser) {
                $browser->assertSee($article->title)
                    ->assertSee($article->created_at->date())
                    ->assertSee($article->summary)
                    ->assertSee(Str::upper($article->first_tag))
                    ->assertSee(Str::upper($article->second_tag))
                    ->assertSee(Str::upper($article->third_tag))
                    ->assertSee(Str::upper($article->fourth_tag));
            });
        });
    }

    /** @test */
    public function a_user_can_show_an_account_but_not_see_some_things_when_they_are_not_part_of_an_organization() : void
    {
        $this->browse(function(Browser $browser) {
            ToolCategoryCollection::seed();

            $user = User::factory()
                ->with(3, School::class)
                ->with(3, Project::class)
                ->with(3, Article::class)
                ->with(3, Workplace::class)
                ->create([
                    'statement' => Str::random(50),
                    'website'   => 'https://www.example.com',
                ]);

            Tool::factory()
                ->belongsTo(Category::first())
                ->with(3, Skill::class, [$user])
                ->create();

            $browser->loginAs($user)
                ->visitRoute('account.show', ['user' => $user->handle])
                ->assertTitle($user->name)
                ->assertSee($user->name);

            $browser->assertDontSee(Str::upper('Employment'));

            Workplace::get()->each(function($workplace) use ($browser) {
                $browser->assertDontSee($workplace->role)
                    ->assertDontSee($workplace->started_at->date())
                    ->assertDontSee($workplace->finished_at->date())
                    ->assertDontSee($workplace->employer)
                    ->assertDontSee($workplace->location)
                    ->assertDontSee($workplace->summary);
            });

            $browser->assertDontSee(Str::upper('Education'));

            School::get()->each(function($school) use ($browser) {
                $browser->assertDontSee($school->course)
                    ->assertDontSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                    ->assertDontSee($school->started_at->date())
                    ->assertDontSee($school->finished_at->date())
                    ->assertDontSee($school->name)
                    ->assertDontSee($school->location);
            });
        });
    }

    /** @test */
    public function a_guest_can_show_an_account_but_not_see_some_things() : void
    {
        $this->browse(function(Browser $browser) {
            ToolCategoryCollection::seed();

            $user = User::factory()
                ->with(3, School::class)
                ->with(3, Article::class)
                ->with(3, Project::class)
                ->with(3, Workplace::class)
                ->create([
                    'statement' => Str::random(50),
                    'website'   => 'https://www.example.com',
                ]);

            Tool::factory()
                ->belongsTo(Category::first())
                ->with(3, Skill::class, [$user])
                ->create();

            $browser->visitRoute('account.show', ['user' => $user->handle])
                ->assertTitle($user->name)
                ->assertSee($user->name);

            $browser->assertDontSee(Str::upper('Employment'));

            Workplace::get()->each(function($workplace) use ($browser) {
                $browser->assertDontSee($workplace->role)
                    ->assertDontSee($workplace->started_at->date())
                    ->assertDontSee($workplace->finished_at->date())
                    ->assertDontSee($workplace->employer)
                    ->assertDontSee($workplace->location)
                    ->assertDontSee($workplace->summary);
            });

            $browser->assertDontSee(Str::upper('Education'));

            School::get()->each(function($school) use ($browser) {
                $browser->assertDontSee($school->course)
                    ->assertDontSee(Str::upper(EducationalQualificationCollection::find($school->qualification)->name))
                    ->assertDontSee($school->started_at->date())
                    ->assertDontSee($school->finished_at->date())
                    ->assertDontSee($school->name)
                    ->assertDontSee($school->location);
            });
        });
    }

    /** @test */
    public function a_user_can_update_their_account() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create([
                'available' => false,
                'full_time' => false,
                'part_time' => false,
                'contract'  => false,
                'emigrate'  => false,
                'remote'    => 1,
                'commute'   => 5,
            ]);

            $payload = User::factory()->make([
                'email'     => $user->email,
                'full_time' => true,
                'part_time' => true,
                'contract'  => true,
                'emigrate'  => true,
                'remote'    => 2,
                'commute'   => 10,
            ]);

            $browser->loginAs($user)
                ->visitRoute('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->assertSee($user->handle)
                ->assertSee('Joined ' . now()->date());

            $browser->assertInputValue('name', $user->name)
                ->assertInputValue('handle', "@{$user->handle}")
                ->assertInputValue('email', $user->email)
                ->assertInputValue('area', $user->area)
                ->assertSelected('country', $user->country)
                ->assertSelected('time_zone', $user->time_zone)
                ->assertInputValue('coordinates', $user->coordinates)
                ->assertSelected('first_language', $user->first_language)
                ->assertSelected('second_language', $user->second_language)
                ->assertSelected('third_language', $user->third_language)
                ->assertInputValue('statement', $user->statement)
                ->assertSelected('remote', $user->remote)
                ->assertSelected('commute', $user->commute)
                ->assertChecked('emigrate', $user->emigrate)
                ->assertChecked('available', $user->available)
                ->assertSelected('currency', $user->currency)
                ->assertInputValue('remuneration', $user->remuneration)
                ->assertChecked('full_time', $user->full_time)
                ->assertChecked('part_time', $user->part_time)
                ->assertChecked('contract', $user->contract)
                ->assertInputValue('website', $user->website)
                ->assertInputValue('github', $user->github)
                ->assertInputValue('twitter', $user->twitter)
                ->assertInputValue('linkedin', $user->linkedin)
                ->assertInputValue('discord', $user->discord)
                ->assertInputValue('youtube', $user->youtube)
                ->assertInputValue('facebook', $user->facebook)
                ->assertInputValue('instagram', $user->instagram);

            $browser->type('name', $payload->name)
                ->type('email', $payload->email)
                ->select('first_language', $payload->first_language)
                ->select('second_language', $payload->second_language)
                ->select('third_language', $payload->third_language)
                ->type('statement', $payload->statement)
                ->scrollToTop();

            $browser->scrollToTop()
                ->click('@set-tab-location');

            $browser->type('area', $payload->area)
                ->select('country', $payload->country)
                ->select('time_zone', $payload->time_zone)
                ->type('coordinates', $payload->coordinates)
                ->select('remote', $payload->remote)
                ->select('commute', $payload->commute)
                ->check('emigrate', $payload->emigrate);

            $browser->scrollToTop()
                ->click('@set-tab-financial');

            $browser->select('currency', $payload->currency)
                ->type('remuneration', $payload->remuneration);

            $browser->scrollToTop()
                ->click('@set-tab-availability');

            $browser->check('available', $payload->available)
                ->check('full_time', $payload->full_time)
                ->check('part_time', $payload->part_time)
                ->check('contract', $payload->contract);

            $browser->scrollToTop()
                ->click('@set-tab-internet');

            $browser->type('website', $payload->website)
                ->type('github', $payload->github)
                ->type('twitter', $payload->twitter)
                ->type('linkedin', $payload->linkedin)
                ->type('discord', $payload->discord)
                ->type('youtube', $payload->youtube)
                ->type('facebook', $payload->facebook)
                ->type('instagram', $payload->instagram)
                ->push('save-account');

            $browser->assertRouteIs('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->assertSee('Your account has been updated');

            $browser->assertInputValue('name', $payload->name)
                ->assertInputValue('handle', "@{$user->handle}")
                ->assertInputValue('email', $payload->email)
                ->assertInputValue('area', $payload->area)
                ->assertSelected('country', $payload->country)
                ->assertSelected('time_zone', $payload->time_zone)
                ->assertInputValue('coordinates', $payload->coordinates)
                ->assertSelected('first_language', $payload->first_language)
                ->assertSelected('second_language', $payload->second_language)
                ->assertSelected('third_language', $payload->third_language)
                ->assertInputValue('statement', $payload->statement)
                ->assertSelected('remote', $payload->remote)
                ->assertSelected('commute', $payload->commute)
                ->assertChecked('emigrate', $payload->emigrate)
                ->assertChecked('available', $payload->available)
                ->assertSelected('currency', $payload->currency)
                ->assertInputValue('remuneration', $payload->remuneration)
                ->assertChecked('full_time', $payload->full_time)
                ->assertChecked('part_time', $payload->part_time)
                ->assertChecked('contract', $payload->contract)
                ->assertInputValue('website', $payload->website)
                ->assertInputValue('github', $payload->github)
                ->assertInputValue('twitter', $payload->twitter)
                ->assertInputValue('linkedin', $payload->linkedin)
                ->assertInputValue('discord', $payload->discord)
                ->assertInputValue('youtube', $payload->youtube)
                ->assertInputValue('facebook', $payload->facebook)
                ->assertInputValue('instagram', $payload->instagram);
        });
    }

    /** @test */
    public function a_user_can_delete_their_account() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visitRoute('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->action('delete-account');

            $browser->assertSee('Delete your account');

            $browser->type('current_password', 'Q5p@4xFvw9w#')
                ->push('delete');

            $browser->assertRouteIs('home')
                ->assertTitle('Lumeno')
                ->assertSee('Lumeno');

            $browser->assertSee('Your account has been deleted');
        });
    }
}
