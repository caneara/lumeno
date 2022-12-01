<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_forgot_password_page() : void
    {
        $this->get(route('password.forgot'))
            ->assertSuccessful()
            ->assertPage('password.forgot');
    }

    /** @test */
    public function a_user_can_request_a_password_reset_link() : void
    {
        Notification::fake();

        RateLimiter::clear(sha1(parse_url(url(''))['host'] . '|' . request()->ip()));

        $user = User::factory()->create();

        $this->postJson(route('password.forgot.store'), ['email' => $user->email])
            ->assertRedirect(route('password.forgot'))
            ->assertNotification('A password reset link has been sent');

        $notification = Notification::assertSent($user, ResetPasswordNotification::class);

        $parameters = [
            'token' => $notification->token,
            'email' => $user->email,
        ];

        $notification->assertSubject('Reset Password')
            ->assertMarkdown('password.reset')
            ->assertAction('Reset Password', route('password.reset', $parameters));
    }

    /** @test */
    public function a_user_is_rate_limited_when_requesting_too_many_password_resets() : void
    {
        Notification::fake();

        RateLimiter::clear(sha1(parse_url(url(''))['host'] . '|' . request()->ip()));

        $user = User::factory()->create();

        for ($i = 0; $i < 3; $i++) {
            $this->postJson(route('password.forgot.store'), ['email' => $user->email]);
        }

        $this->postJson(route('password.forgot.store'), ['email' => $user->email])
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    }
}
