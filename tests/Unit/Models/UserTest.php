<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Types\ServerTest;

class UserTest extends ServerTest
{
    /** @test */
    public function it_knows_if_it_is_a_customer() : void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->employee()->create();

        $this->assertTrue($user_1->isCustomer());
        $this->assertFalse($user_2->isCustomer());
    }

    /** @test */
    public function it_knows_if_it_is_an_employee() : void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->employee()->create();

        $this->assertFalse($user_1->isEmployee());
        $this->assertTrue($user_2->isEmployee());
    }
}
