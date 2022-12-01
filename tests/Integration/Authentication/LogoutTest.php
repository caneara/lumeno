<?php

namespace Tests\Integration\Authentication;

use App\Models\User;
use App\Types\ServerTest;

class LogoutTest extends ServerTest
{
    /** @test */
    public function a_user_can_logout() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->assertAuthenticatedAs($user);

        $this->get(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
