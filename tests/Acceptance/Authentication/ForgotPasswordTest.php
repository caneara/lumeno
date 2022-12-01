<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;

class ForgotPasswordTest extends ClientTest
{
    /** @test */
    public function a_user_can_request_a_password_reset_link() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->visitRoute('password.forgot')
                ->assertTitle('Forgot Password')
                ->assertSee('Forgotten your password?');

            $browser->type('email', $user->email)
                ->push('send');

            $browser->assertRouteIs('password.forgot')
                ->assertTitle('Forgot Password')
                ->assertSee('Forgotten your password?');

            $browser->assertSee('A password reset link has been sent');
        });
    }
}
