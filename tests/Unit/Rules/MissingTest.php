<?php

namespace Tests\Unit\Rules;

use App\Models\User;
use App\Types\ServerTest;
use App\Rules\MissingRule;

class MissingTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $rule = ['id' => [MissingRule::make('users', 'id')]];

        $this->assertFalse(validator(['id' => 5], $rule)->fails());

        $this->assertTrue(validator(['id' => $user_1->id], $rule)->fails());
        $this->assertTrue(validator(['id' => $user_2->id], $rule)->fails());
    }
}
