<?php

namespace Tests\Unit\Rules;

use App\Types\ServerTest;
use App\Collections\CountryCollection;

class InRepositoryTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $rule = ['country' => [CountryCollection::rule('code')]];

        $this->assertFalse(validator(['country' => 'AF'], $rule)->fails());
        $this->assertTrue(validator(['country' => 'XX'], $rule)->fails());
    }
}
