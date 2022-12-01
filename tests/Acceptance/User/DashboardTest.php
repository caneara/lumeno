<?php

namespace Tests\Acceptance\User;

use App\Models\User;
use App\Types\Browser;
use App\Types\ClientTest;
use Illuminate\Support\Str;

class DashboardTest extends ClientTest
{
    /**
     * Determine the relevant greeting to show based on the time of day.
     *
     */
    protected function greeting() : string
    {
        $time_zone = shell_exec('date +"%z"');

        $offset = (int) substr($time_zone, 1, 2);

        $method = Str::startsWith($time_zone, '+') ? 'addHours' : 'subHours';

        $hour = now()->$method($offset)->hour;

        return $hour < 12 ? 'morning' : ($hour < 18 ? 'afternoon' : 'evening');
    }

    /** @test */
    public function a_user_can_view_the_dashboard_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()
                ->create(['name' => 'John Doe']);

            $browser->loginAs($user)
                ->visitRoute('dashboard.user')
                ->assertTitle('Dashboard');

            $browser->assertSee("Good {$this->greeting()}, {$user->name}");
        });
    }
}
