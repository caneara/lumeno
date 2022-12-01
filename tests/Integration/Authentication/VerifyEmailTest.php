<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailAddressNotification;

class VerifyEmailTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_email_verification_page() : void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.user'))
            ->assertRedirect(route('email.verify.notice'));

        $this->get(route('email.verify.notice'))
            ->assertPage('email.index');
    }

    /** @test */
    public function a_user_can_request_that_the_email_verification_link_be_resent() : void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->postJson(route('email.verify.send'))
            ->assertRedirect(route('email.verify.notice'))
            ->assertNotification('A link has been sent to your email');

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
    public function a_user_can_verify_their_email_address() : void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->actingAs($user)
            ->postJson(route('email.verify.send'))
            ->assertRedirect(route('email.verify.notice'))
            ->assertNotification('A link has been sent to your email');

        $parameters = [
            'id'   => $user->getKey(),
            'hash' => sha1($user->email),
        ];

        $url = Notification::assertSent($user, VerifyEmailAddressNotification::class)
            ->assertSubject('Verify Email')
            ->assertMarkdown('email.verify')
            ->assertAction('Verify Email Address', route('email.verify.confirm', $parameters), false)
            ->getActionUrl();

        $this->get($url)
            ->assertRedirect(route('dashboard.user'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
