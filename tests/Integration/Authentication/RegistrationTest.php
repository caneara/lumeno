<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Models\Member;
use App\Types\ServerTest;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailAddressNotification;

class RegistrationTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_registration_page_without_enlisting() : void
    {
        $this->get(route('register'))
            ->assertSuccessful()
            ->assertSessionMissing('enlist')
            ->assertPage('register.index');
    }

    /** @test */
    public function a_user_can_view_the_registration_page_with_an_invalid_enlist_payload() : void
    {
        $this->get(route('register', ['enlist' => 'test']))
            ->assertSuccessful()
            ->assertSessionMissing('enlist')
            ->assertPage('register.index');
    }

    /** @test */
    public function a_user_can_view_the_registration_page_with_an_valid_enlist_payload() : void
    {
        $this->get(route('register', ['enlist' => $payload = encrypt('test')]))
            ->assertSuccessful()
            ->assertSessionHas('enlist', $payload)
            ->assertPage('register.index');
    }

    /** @test */
    public function a_user_can_register_for_an_account_without_enlisting() : void
    {
        Notification::fake();

        $payload = [
            'name'                  => 'John Doe',
            'handle'                => 'johndoe',
            'email'                 => 'john@example.com',
            'password'              => 'Q5p@4xFvw9w#',
            'password_confirmation' => 'Q5p@4xFvw9w#',
            'terms'                 => true,
        ];

        $this->postJson(route('register.store'), $payload)
            ->assertRedirect(route('email.verify.notice'));

        $this->assertAuthenticated();

        $this->assertCount(1, User::get());

        $this->assertTrue(User::first()->isCustomer());
        $this->assertNull(User::first()->email_verified_at);
        $this->assertEquals('John Doe', User::first()->name);
        $this->assertEquals('johndoe', User::first()->handle);
        $this->assertEquals('john@example.com', User::first()->email);
        $this->assertTrue(Hash::check('Q5p@4xFvw9w#', User::first()->password));

        $parameters = [
            'id'   => User::first()->getKey(),
            'hash' => sha1($payload['email']),
        ];

        Notification::assertSent(User::first(), VerifyEmailAddressNotification::class)
            ->assertSubject('Verify Email')
            ->assertMarkdown('email.verify')
            ->assertAction('Verify Email Address', route('email.verify.confirm', $parameters), false);
    }

    /** @test */
    public function a_user_can_register_for_an_account_and_enlist() : void
    {
        Notification::fake();

        $organization = Organization::factory()->create();

        $payload = [
            'name'                  => 'John Doe',
            'handle'                => 'johndoe',
            'email'                 => 'john@example.com',
            'password'              => 'Q5p@4xFvw9w#',
            'password_confirmation' => 'Q5p@4xFvw9w#',
            'terms'                 => true,
        ];

        $enlist = [
            'organization' => $organization->id,
            'role'         => Member::ROLE_ASSOCIATE,
        ];

        $this->withSession(['enlist' => encrypt($enlist)])
            ->postJson(route('register.store'), $payload)
            ->assertRedirect(route('email.verify.notice'));

        $this->assertAuthenticated();

        $this->assertCount(1, User::get());
        $this->assertCount(1, Member::get());
        $this->assertCount(1, Organization::get());

        $this->assertTrue(User::first()->isCustomer());
        $this->assertNull(User::first()->email_verified_at);
        $this->assertEquals('John Doe', User::first()->name);
        $this->assertEquals('johndoe', User::first()->handle);
        $this->assertEquals('john@example.com', User::first()->email);
        $this->assertTrue(Hash::check('Q5p@4xFvw9w#', User::first()->password));

        $this->assertTrue(Member::first()->user->is(User::first()));
        $this->assertEquals(Member::ROLE_ASSOCIATE, Member::first()->role);
        $this->assertTrue(Member::first()->organization->is($organization));

        $parameters = [
            'id'   => User::first()->getKey(),
            'hash' => sha1($payload['email']),
        ];

        Notification::assertSent(User::first(), VerifyEmailAddressNotification::class)
            ->assertSubject('Verify Email')
            ->assertMarkdown('email.verify')
            ->assertAction('Verify Email Address', route('email.verify.confirm', $parameters), false);
    }
}
