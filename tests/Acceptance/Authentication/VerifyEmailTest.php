<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;

class VerifyEmailTest extends ClientTest
{
    /** @test */
    public function a_user_can_request_a_new_email_verification_code() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create(['email_verified_at' => null]);

            $browser->loginAs($user)
                ->visitRoute('email.verify.notice')
                ->assertTitle('Verify Email')
                ->assertSee('Verify your email address');

            $browser->push('resend');

            $browser->assertRouteIs('email.verify.notice')
                ->assertTitle('Verify Email')
                ->assertSee('Verify your email address');

            $browser->assertSee('A link has been sent to your email');
        });
    }
}
