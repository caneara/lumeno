<?php

namespace Tests\Unit\Rules;

use App\Types\ServerTest;
use App\Rules\BeforeWhenPresentRule;

class BeforeWhenPresentTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $data = ['start' => now()->toDateString()];

        $rule = ['start' => [new BeforeWhenPresentRule('finish')]];

        $payload = [
            [false, ['finish' => '']],
            [false, ['finish' => null]],
            [false, ['finish' => now()->addDay()->toDateString()]],
            [true,  ['finish' => now()->subDay()->toDateString()]],
        ];

        foreach ($payload as $item) {
            request()->replace($item[1]);

            $this->assertEquals($item[0], validator($data, $rule)->fails());
        }
    }
}
