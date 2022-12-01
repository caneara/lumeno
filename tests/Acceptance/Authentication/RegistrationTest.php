<?php

namespace Tests\Acceptance\Authentication;

use App\Types\Browser;
use App\Types\ClientTest;

class RegistrationTest extends ClientTest
{
    /** @test */
    public function a_user_can_register_for_an_account() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('register')
                ->assertTitle('Register')
                ->assertSee('Create a new account');

            $browser->type('name', 'John Doe')
                ->type('handle', 'johndoe')
                ->type('email', 'john@example.com')
                ->type('password', 'Q5p@4xFvw9w#')
                ->type('password_confirmation', 'Q5p@4xFvw9w#')
                ->check('terms')
                ->push('create');

            $browser->assertRouteIs('email.verify.notice')
                ->assertTitle('Verify Email')
                ->assertSee('Verify your email address');
        });
    }
}
