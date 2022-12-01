<?php

namespace Tests\Acceptance\Administration;

use App\Models\Tool;
use App\Models\User;
use App\Types\Browser;
use App\Models\Article;
use App\Models\Vacancy;
use App\Types\ClientTest;
use App\Models\Organization;

class DashboardTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_dashboard_page() : void
    {
        $this->browse(function(Browser $browser) {
            $user = User::factory()->employee()->create();

            User::factory()
                ->with(3, Article::class)
                ->create(['created_at' => now()->subDays(40)]);

            Organization::factory()
                ->with(3, Vacancy::class, [], ['created_at' => now()])
                ->hasSubscription('Silver')
                ->create(['created_at' => now()]);

            Organization::factory()
                ->hasSubscription()
                ->with(Vacancy::class, [], ['created_at' => now()->subDays(40)])
                ->create(['created_at' => now()->subDays(40)]);

            Tool::factory()->create(['approved' => false]);

            $browser->loginAs($user)
                ->visitRoute('dashboard.admin')
                ->assertTitle('Dashboard')
                ->assertSee('Dashboard');

            $browser->assertSee('2 users')
                ->assertSee('4 vacancies')
                ->assertSee('2 organizations')
                ->assertSee('2 subscriptions');

            $browser->assertSee('1 tool awaiting review.');
        });
    }
}
