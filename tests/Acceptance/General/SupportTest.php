<?php

namespace Tests\Acceptance\General;

use App\Types\Browser;
use App\Types\ClientTest;

class SupportTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_support_page() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('support')
                ->assertTitle('Support')
                ->assertSee('Support Center');
        });
    }
}
