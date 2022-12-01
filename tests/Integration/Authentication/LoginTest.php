<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;

class LoginTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_login_page() : void
    {
        $this->get(route('login'))
            ->assertSuccessful()
            ->assertPage('login.index');
    }

    /** @test */
    public function a_user_with_a_verified_email_address_can_login() : void
    {
        $user = User::factory()->create();

        $payload = [
            'email'    => $user->email,
            'password' => 'Q5p@4xFvw9w#',
        ];

        $this->postJson(route('login.store'), $payload)
            ->assertRedirect(route('dashboard.user'));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function a_user_with_an_unverified_email_address_can_login_but_must_confirm_their_email_afterwards() : void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $payload = [
            'email'    => $user->email,
            'password' => 'Q5p@4xFvw9w#',
        ];

        $this->followingRedirects()
            ->postJson(route('login.store'), $payload)
            ->assertPage('email.index');

        $this->get(route('dashboard.user'))
            ->assertRedirect(route('email.verify.notice'));

        $this->assertAuthenticatedAs($user);
    }
}
