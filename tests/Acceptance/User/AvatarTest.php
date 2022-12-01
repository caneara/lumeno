<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Storage\Image;
use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Facades\File;

class AvatarTest extends ClientTest
{
    /** @test */
    public function a_user_can_update_their_avatar() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->create();

            Image::put($original = $user->avatar, File::get(public_path('img/user.jpg')));

            $browser->loginAs($user)
                ->visitRoute('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->attach('file', public_path('img/user.jpg'))
                ->push('save-avatar');

            $browser->assertRouteIs('account.edit')
                ->assertTitle('Account')
                ->assertSee('Account');

            $browser->assertSee('Your account has been updated');

            $this->assertNotEquals($original, $user->fresh()->avatar);
        });
    }
}
