<?php

namespace Tests\Unit\Rules;

use App\Rules\BlankRule;
use App\Types\ServerTest;

class BlankTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $rule = ['text' => [BlankRule::make()]];

        $this->assertTrue(validator(['text' => 0], $rule)->fails());
        $this->assertTrue(validator(['text' => '0'], $rule)->fails());
        $this->assertTrue(validator(['text' => 'test'], $rule)->fails());
        $this->assertTrue(validator(['text' => true], $rule)->fails());
        $this->assertTrue(validator(['text' => false], $rule)->fails());
        $this->assertTrue(validator(['text' => ['test']], $rule)->fails());

        $this->assertFalse(validator(['text' => ''], $rule)->fails());
        $this->assertFalse(validator(['text' => []], $rule)->fails());
        $this->assertFalse(validator(['text' => null], $rule)->fails());
    }
}
