<?php

namespace App\Actions\Article;

use App\Types\Action;
use App\Storage\Image;
use App\Models\Article;

class UpdateAction extends Action
{
    /**
     * Update the given article using the given payload.
     *
     */
    public static function execute(Article $article, array $payload) : Article
    {
        if ($article->banner !== $payload['banner']) {
            Image::delete($article->banner);
        }

        return attempt(fn() => tap($article)->update($payload));
    }
}
