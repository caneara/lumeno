<?php

namespace Tests\Acceptance\General;

use App\Types\Browser;
use App\Types\ClientTest;

class GuideTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_guide() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('guide')
                ->assertTitle('Guide - Introduction')
                ->assertSee('Introduction');
        });
    }

    /** @test */
    public function a_user_can_view_a_page_in_the_guide() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('guide', ['page' => 'interface'])
                ->assertTitle('Guide - Interface')
                ->assertSee('Interface');
        });
    }

    /** @test */
    public function a_user_cannot_view_a_missing_page_in_a_guide() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('guide', ['page' => 'test'])
                ->assertTitle('Guide - Test')
                ->assertSee('404 - File Not Found');
        });
    }
}
