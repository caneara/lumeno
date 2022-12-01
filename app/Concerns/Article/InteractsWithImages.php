<?php

namespace App\Concerns\Article;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait InteractsWithImages
{
    /**
     * Find all of the images contained within the article's content.
     *
     */
    public function embeddedImages() : Collection
    {
        $regex = '/' . preg_quote(Storage::url('images/'), '/') . '([0-9a-zA-Z-]{36})\.jpg/mi';

        preg_match_all($regex, $this->content, $matches, PREG_SET_ORDER);

        return collect($matches)->map(fn($item) => $item[1]);
    }
}
