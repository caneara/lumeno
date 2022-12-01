<?php

namespace Tests\Acceptance\General;

use App\Types\Browser;
use App\Types\ClientTest;

class EmployerTest extends ClientTest
{
    /** @test */
    public function a_user_can_view_the_employers_page() : void
    {
        $this->browse(function(Browser $browser) {
            $browser->visitRoute('employers')
                ->assertTitle('Employers')
                ->assertSee('Lumeno');
        });
    }
}
