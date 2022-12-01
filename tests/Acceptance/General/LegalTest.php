<?php

namespace Tests\Acceptance\General;

use App\Types\Browser;
use App\Types\ClientTest;

class LegalTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_legal_page() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('legal')
                ->assertTitle('Legal')
                ->assertSee('Legal Information');
        });
    }
}
