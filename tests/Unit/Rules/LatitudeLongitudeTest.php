<?php

namespace Tests\Unit\Rules;

use App\Types\ServerTest;
use App\Rules\LatitudeLongitudeRule;

class LatitudeLongitudeTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $rule = ['coordinates' => [LatitudeLongitudeRule::make()]];

        $this->assertFalse(validator(['coordinates' => '-77.03,38.89'], $rule)->fails());
        $this->assertTrue(validator(['coordinates' => '-77.0,38.8'], $rule)->fails());
        $this->assertTrue(validator(['coordinates' => '-77.036,38.895'], $rule)->fails());
        $this->assertTrue(validator(['coordinates' => 'XX'], $rule)->fails());
    }
}
