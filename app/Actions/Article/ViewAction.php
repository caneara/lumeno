<?php

namespace App\Actions\Article;

use App\Models\User;
use App\Types\Action;
use Illuminate\Contracts\Pagination\Paginator;

class ViewAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'id',
        'slug',
        'title',
        'summary',
        'first_tag',
        'second_tag',
        'third_tag',
        'fourth_tag',
        'created_at',
    ];

    /**
     * Retrieve a list of articles owned by the given user.
     *
     */
    public static function execute(User $user, string $title) : Paginator
    {
        return $user->articles()
            ->whereLike('title', $title)
            ->orderByDesc('id')
            ->simplePaginate(5, static::$fields);
    }
}
