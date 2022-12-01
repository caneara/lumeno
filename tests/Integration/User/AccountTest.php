<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Models\Member;
use App\Storage\Image;
use App\Models\Article;
use App\Models\Project;
use App\Types\ServerTest;
use App\Models\Organization;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailAddressNotification;

class AccountTest extends ServerTest
{
    /** @test */
    public function a_user_can_edit_their_account() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.edit'))
            ->assertSuccessful()
            ->assertPage('account.edit.index');
    }

    /** @test */
    public function a_user_can_show_an_account() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('account.show', ['user' => $user->handle]))
            ->assertSuccessful()
            ->assertPage('account.show.index');
    }

    /** @test */
    public function a_user_can_update_their_account() : void
    {
        $user = User::factory()->create();

        $payload = User::factory()->make([
            'email'       => $user->email,
            'coordinates' => '-84.41,-26.12',
        ]);

        $this->actingAs($user)
            ->patchJson(route('account.update'), $payload->toArray())
            ->assertRedirect(route('account.edit'))
            ->assertNotification('Your account has been updated');

        $this->get(route('account.edit'))
            ->assertSuccessful();

        $this->assertEquals($user->fresh()->name, $payload->name);
        $this->assertEquals($user->fresh()->email, $payload->email);
        $this->assertEquals($user->fresh()->available, $payload->available);
        $this->assertEquals($user->fresh()->country, $payload->country);
        $this->assertEquals($user->fresh()->area, $payload->area);
        $this->assertEquals($user->fresh()->coordinates, $payload->coordinates);
        $this->assertEquals($user->fresh()->time_zone, $payload->time_zone);
        $this->assertEquals($user->fresh()->full_time, $payload->full_time);
        $this->assertEquals($user->fresh()->part_time, $payload->part_time);
        $this->assertEquals($user->fresh()->contract, $payload->contract);
        $this->assertEquals($user->fresh()->first_language, $payload->first_language);
        $this->assertEquals($user->fresh()->second_language, $payload->second_language);
        $this->assertEquals($user->fresh()->third_language, $payload->third_language);
        $this->assertEquals($user->fresh()->emigrate, $payload->emigrate);
        $this->assertEquals($user->fresh()->remote, $payload->remote);
        $this->assertEquals($user->fresh()->commute, $payload->commute);
        $this->assertEquals($user->fresh()->currency, $payload->currency);
        $this->assertEquals($user->fresh()->remuneration, $payload->remuneration);
        $this->assertEquals($user->fresh()->website, $payload->website);
        $this->assertEquals($user->fresh()->github, $payload->github);
        $this->assertEquals($user->fresh()->twitter, $payload->twitter);
        $this->assertEquals($user->fresh()->linkedin, $payload->linkedin);
        $this->assertEquals($user->fresh()->discord, $payload->discord);
        $this->assertEquals($user->fresh()->youtube, $payload->youtube);
        $this->assertEquals($user->fresh()->facebook, $payload->facebook);
        $this->assertEquals($user->fresh()->instagram, $payload->instagram);
        $this->assertEquals($user->fresh()->statement, $payload->statement);
    }

    /** @test */
    public function a_user_must_verify_their_email_address_if_they_have_changed_it() : void
    {
        Notification::fake();

        $user = User::factory()->create();

        $payload = User::factory()->make(['coordinates' => '-84.41,-26.12']);

        $this->actingAs($user)
            ->patchJson(route('account.update'), $payload->toArray())
            ->assertRedirect(route('account.edit'))
            ->assertNotification('Your account has been updated');

        $this->get(route('account.edit'))
            ->assertRedirect(route('email.verify.notice'));

        $this->assertEquals($user->fresh()->name, $payload->name);
        $this->assertEquals($user->fresh()->email, $payload->email);
        $this->assertEquals($user->fresh()->available, $payload->available);
        $this->assertEquals($user->fresh()->country, $payload->country);
        $this->assertEquals($user->fresh()->area, $payload->area);
        $this->assertEquals($user->fresh()->coordinates, $payload->coordinates);
        $this->assertEquals($user->fresh()->time_zone, $payload->time_zone);
        $this->assertEquals($user->fresh()->full_time, $payload->full_time);
        $this->assertEquals($user->fresh()->part_time, $payload->part_time);
        $this->assertEquals($user->fresh()->contract, $payload->contract);
        $this->assertEquals($user->fresh()->first_language, $payload->first_language);
        $this->assertEquals($user->fresh()->second_language, $payload->second_language);
        $this->assertEquals($user->fresh()->third_language, $payload->third_language);
        $this->assertEquals($user->fresh()->emigrate, $payload->emigrate);
        $this->assertEquals($user->fresh()->remote, $payload->remote);
        $this->assertEquals($user->fresh()->commute, $payload->commute);
        $this->assertEquals($user->fresh()->currency, $payload->currency);
        $this->assertEquals($user->fresh()->remuneration, $payload->remuneration);
        $this->assertEquals($user->fresh()->website, $payload->website);
        $this->assertEquals($user->fresh()->github, $payload->github);
        $this->assertEquals($user->fresh()->twitter, $payload->twitter);
        $this->assertEquals($user->fresh()->linkedin, $payload->linkedin);
        $this->assertEquals($user->fresh()->discord, $payload->discord);
        $this->assertEquals($user->fresh()->youtube, $payload->youtube);
        $this->assertEquals($user->fresh()->facebook, $payload->facebook);
        $this->assertEquals($user->fresh()->instagram, $payload->instagram);
        $this->assertEquals($user->fresh()->statement, $payload->statement);

        $parameters = [
            'id'   => $user->getKey(),
            'hash' => sha1($user->email),
        ];

        Notification::assertSent($user, VerifyEmailAddressNotification::class)
            ->assertSubject('Verify Email')
            ->assertMarkdown('email.verify')
            ->assertAction('Verify Email Address', route('email.verify.confirm', $parameters), false);
    }

    /** @test */
    public function a_user_can_delete_their_account() : void
    {
        $user = User::factory()->create();

        $project = Project::factory()->belongsTo($user)->create();

        $article = Article::factory()->belongsTo($user)->create([
            'content' => 'test' . Image::fake($embed = uuid()) . 'test',
        ]);

        Image::fake($user->avatar);

        Image::fake($project->logo);
        Image::fake($project->first_image);
        Image::fake($project->second_image);
        Image::fake($project->third_image);

        Image::fake($article->banner);

        $this->actingAs($user)
            ->deleteJson(route('account.delete'), ['password' => 'Q5p@4xFvw9w#'])
            ->assertRedirect(route('home'))
            ->assertNotification('Your account has been deleted');

        $this->assertGuest();

        $this->assertCount(0, User::get());
        $this->assertCount(0, Project::get());
        $this->assertCount(0, Article::get());

        Image::assertMissing($user->avatar);

        Image::assertMissing($project->logo);
        Image::assertMissing($project->first_image);
        Image::assertMissing($project->second_image);
        Image::assertMissing($project->third_image);

        Image::assertMissing($article->banner);

        Image::assertMissing($embed);
    }

    /** @test */
    public function a_user_can_delete_their_account_and_organization_if_they_are_the_only_member() : void
    {
        $user = User::factory()->create();

        $organization = Organization::factory()->hasSubscription()->create();

        Member::factory()->belongsTo($organization, $user)->create();

        $this->actingAs($user)
            ->deleteJson(route('account.delete'), ['password' => 'Q5p@4xFvw9w#'])
            ->assertRedirect(route('home'))
            ->assertNotification('Your account has been deleted');

        $this->assertGuest();

        $this->assertCount(0, User::get());
        $this->assertCount(0, Member::get());
        $this->assertCount(0, Organization::get());
    }

    /** @test */
    public function a_user_can_delete_their_account_but_not_their_organization_when_there_are_other_members() : void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $organization = Organization::factory()->hasSubscription()->create();

        $member_1 = Member::factory()->belongsTo($organization, $user_1)->create();
        $member_2 = Member::factory()->belongsTo($organization, $user_2)->create();

        $this->actingAs($user_1)
            ->deleteJson(route('account.delete'), ['password' => 'Q5p@4xFvw9w#'])
            ->assertRedirect(route('home'))
            ->assertNotification('Your account has been deleted');

        $this->assertGuest();

        $this->assertCount(1, User::get());
        $this->assertCount(1, Member::get());
        $this->assertCount(1, Organization::get());

        $this->assertTrue(User::first()->is($user_2));
        $this->assertTrue(Member::first()->is($member_2));
        $this->assertTrue(Organization::first()->is($organization));
    }
}
