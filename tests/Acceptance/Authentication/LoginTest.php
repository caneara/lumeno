<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;

class LoginTest extends ClientTest
{
    /** @test */
    public function a_user_can_sign_in() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->visitRoute('login')
                ->assertTitle('Login')
                ->assertSee('Sign into your account');

            $browser->type('email', $user->email)
                ->type('password', 'Q5p@4xFvw9w#')
                ->check('remember')
                ->push('login');

            $browser->assertRouteIs('dashboard.user')
                ->assertTitle('Dashboard')
                ->assertSee('dashboard');

            $browser->visitRoute('logout')
                ->pause();

            $browser->assertRouteIs('home')
                ->assertTitle('Lumeno')
                ->assertSee('Lumeno');
        });
    }
}
