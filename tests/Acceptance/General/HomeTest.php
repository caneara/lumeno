<?php

namespace Tests\Acceptance\General;

use App\Types\Browser;
use App\Types\ClientTest;

class HomeTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_home_page() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('home')
                ->assertTitle('Lumeno')
                ->assertSee('Lumeno');
        });
    }
}
