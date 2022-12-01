<?php

namespace Tests\Integration\General;

use App\Types\ServerTest;

class EmployerTest extends ServerTest
{
    /** @test */
    public function a_user_can_view_the_employers_page() : void
    {
        $this->get(route('employers'))
            ->assertSuccessful()
            ->assertPage('employers.index');
    }
}
