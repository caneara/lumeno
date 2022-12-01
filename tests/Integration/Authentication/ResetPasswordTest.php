<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class ResetPasswordTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_reset_password_page() : void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->postJson(route('password.forgot.store'), ['email' => $user->email]);

        $notification = Notification::assertSent($user, ResetPasswordNotification::class);

        $parameters = [
            'token' => $notification->token,
            'email' => $user->email,
        ];

        $url = $notification->assertSubject('Reset Password')
            ->assertMarkdown('password.reset')
            ->assertAction('Reset Password', route('password.reset', $parameters))
            ->getActionUrl();

        $this->get($url)
            ->assertSuccessful()
            ->assertPage('password.reset');
    }

    /** @test */
    public function a_user_can_reset_their_password() : void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->assertTrue(Hash::check('Q5p@4xFvw9w#', $user->password));

        $this->postJson(route('password.forgot.store'), ['email' => $user->email]);

        $mail = Notification::assertSent($user, ResetPasswordNotification::class);

        $parameters = [
            'token' => $mail->token,
            'email' => $user->email,
        ];

        $url = $mail->assertSubject('Reset Password')
            ->assertMarkdown('password.reset')
            ->assertAction('Reset Password', route('password.reset', $parameters))
            ->getActionUrl();

        $payload = [
            'token'                 => (string) str($url)->after('reset/')->before('?'),
            'email'                 => $user->email,
            'password'              => 'R5p@4xFvw9w#',
            'password_confirmation' => 'R5p@4xFvw9w#',
        ];

        $this->postJson(route('password.reset.store'), $payload)
            ->assertRedirect(route('dashboard.user'))
            ->assertNotification('Your password has been updated');

        $this->assertTrue(Hash::check('R5p@4xFvw9w#', $user->fresh()->password));
    }
}
