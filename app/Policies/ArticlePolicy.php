<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Article;

class ArticlePolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given article.
     *
     */
    public function delete(User $user, Article $article) : bool
    {
        return $user->owns($article);
    }

    /**
     * Determine whether the given user can edit the given article.
     *
     */
    public function edit(User $user, Article $article) : bool
    {
        return $user->owns($article);
    }

    /**
     * Determine whether the given user can update the given article.
     *
     */
    public function update(User $user, Article $article) : bool
    {
        return $user->owns($article);
    }
}
