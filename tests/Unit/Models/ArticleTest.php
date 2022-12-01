<?php

namespace Tests\Unit\Models;

use App\Storage\Image;
use App\Models\Article;
use App\Types\ServerTest;
use Illuminate\Support\Str;

class ArticleTest extends ServerTest
{
    /** @test */
    public function it_can_find_the_embedded_images_in_its_content() : void
    {
        $content = Str::random(50) . Image::url($first = uuid()) . Str::random(50) . Image::url($second = uuid()) . Str::random(50);

        $article = Article::factory()->create(['content' => $content]);

        $this->assertEquals($article->embeddedImages(), collect([$first, $second]));
    }
}
