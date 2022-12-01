<?php

namespace Tests\Unit\Rules;

use App\Storage\Image;
use App\Rules\ImageRule;
use App\Types\ServerTest;
use League\Flysystem\UnableToRetrieveMetadata;

class ImageTest extends ServerTest
{
    /** @test */
    public function it_confirms_the_validation_rule_works_as_expected() : void
    {
        $rule = ['file' => [ImageRule::make('images/')]];

        Image::fake('valid');

        $this->assertFalse(validator(['file' => 'valid.jpg'], $rule)->fails());

        $this->expectException(UnableToRetrieveMetadata::class);

        $this->assertTrue(validator(['file' => 'invalid.jpg'], $rule)->fails());
    }
}
