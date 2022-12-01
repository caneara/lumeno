<?php

namespace Tests\Integration\User;

use App\Models\User;
use App\Types\ServerTest;

class DashboardTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_dashboard_page() : void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard.user'))
            ->assertSuccessful()
            ->assertPage('dashboard.user.index');
    }
}
