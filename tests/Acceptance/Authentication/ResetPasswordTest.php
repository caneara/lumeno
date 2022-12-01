<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class ResetPasswordTest extends ClientTest
{
    /** @test */
    public function a_user_can_reset_their_password() : void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->postJson(route('password.forgot.store'), ['email' => $user->email]);

        $mail = Notification::assertSent($user, ResetPasswordNotification::class);

        $this->browse(function(Browser $browser) use ($mail) {
            $browser->visit($mail->getActionUrl())
                ->assertTitle('Reset Password')
                ->assertSee('Reset your password');

            $browser->type('password', 'R5p@4xFvw9w#')
                ->type('password_confirmation', 'R5p@4xFvw9w#')
                ->push('update');

            $browser->assertRouteIs('dashboard.user')
                ->assertTitle('Dashboard')
                ->assertSee('dashboard');

            $browser->assertSee('Your password has been updated');
        });
    }
}
