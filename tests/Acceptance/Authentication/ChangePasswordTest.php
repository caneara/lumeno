<?php

namespace Tests\Acceptance\Authentication;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;

class ChangePasswordTest extends ClientTest
{
    /** @test */
    public function a_user_can_change_their_password() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            $browser->loginAs($user)
                ->visitRoute('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->action('change-password');

            $browser->assertSee('Change your password');

            $browser->type('old_password', 'Q5p@4xFvw9w#')
                ->type('new_password', 'R5p@4xFvw9w#')
                ->type('new_password_confirmation', 'R5p@4xFvw9w#')
                ->push('save-password');

            $browser->assertRouteIs('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->assertSee('Your password has been updated');
        });
    }
}
