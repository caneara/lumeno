<?php

namespace App\Actions\Article;

use App\Models\User;
use App\Types\Action;
use App\Models\Article;
use Illuminate\Support\Str;

class StoreAction extends Action
{
    /**
     * Create a new article using the given payload.
     *
     */
    public static function execute(User $user, array $payload) : Article
    {
        $payload['slug'] = Str::slug($payload['title']);

        return attempt(fn() => $user->articles()->create($payload));
    }
}
