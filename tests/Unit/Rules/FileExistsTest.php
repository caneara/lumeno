<?php

namespace Tests\Unit\Rules;

use App\Storage\Image;
use App\Types\ServerTest;
use App\Rules\FileExistsRule;

class FileExistsTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $rule_1 = ['file' => [FileExistsRule::make('images/')]];
        $rule_2 = ['file' => [FileExistsRule::make('images/', '.jpg')]];

        Image::fake('exists');

        $this->assertTrue(validator(['file' => 'missing.jpg'], $rule_1)->fails());
        $this->assertFalse(validator(['file' => 'exists.jpg'], $rule_1)->fails());

        $this->assertTrue(validator(['file' => 'missing'], $rule_2)->fails());
        $this->assertFalse(validator(['file' => 'exists'], $rule_2)->fails());
    }
}
