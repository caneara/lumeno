<?php

namespace Tests\Integration\Administration;

use App\Models\User;
use App\Types\ServerTest;

class DashboardTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_dashboard_page() : void
    {
        $user = User::factory()->employee()->create();

        $this->actingAs($user)
            ->get(route('dashboard.admin'))
            ->assertSuccessful()
            ->assertPage('dashboard.admin.index');
    }
}
