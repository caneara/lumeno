<?php

namespace App\Actions\Article;

use App\Types\Action;
use App\Storage\Image;
use App\Models\Article;

class DeleteAction extends Action
{
    /**
     * Delete the given article.
     *
     */
    public static function execute(Article $article) : void
    {
        Image::delete($article->banner);

        Image::delete($article->embeddedImages());

        attempt(fn() => $article->delete());
    }
}
