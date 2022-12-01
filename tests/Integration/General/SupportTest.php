<?php

namespace Tests\Integration\General;

use App\Types\ServerTest;

class SupportTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_support_page() : void
    {
        $this->get(route('support'))
            ->assertSuccessful()
            ->assertPage('support.index');
    }
}
