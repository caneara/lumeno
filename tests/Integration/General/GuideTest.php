<?php

namespace Tests\Integration\General;

use App\Types\ServerTest;

class GuideTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_guide_page() : void
    {
        $this->get(route('guide'))
            ->assertSuccessful()
            ->assertPage('guide.index');
    }

    /** @test */
    public function a_user_can_view_a_page_in_the_guide() : void
    {
        $this->get(route('guide', ['page' => 'registration']))
            ->assertSuccessful()
            ->assertPage('guide.index');
    }
}
