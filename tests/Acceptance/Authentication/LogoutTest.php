<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;

class LogoutTest extends ClientTest
{
    /** @test */
    public function a_user_can_sign_out() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visitRoute('dashboard.user')
                ->pause();

            $browser->assertRouteIs('dashboard.user')
                ->assertTitle('Dashboard')
                ->assertSee('dashboard');

            $browser->visitRoute('logout')
                ->pause();

            $browser->assertRouteIs('home')
                ->assertTitle('Lumeno')
                ->assertSee('Lumeno');

            $browser->assertGuest();

            $browser->visitRoute('dashboard.user')
                ->pause();

            $browser->assertRouteIs('login')
                ->assertTitle('Login')
                ->assertSee('Sign into your account');
        });
    }
}
