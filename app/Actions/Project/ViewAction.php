<?php

namespace App\Actions\Project;

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
        'projects.id',
        'projects.type',
        'projects.logo',
        'projects.title',
        'projects.summary',
        'projects.first_tag',
        'projects.second_tag',
        'projects.third_tag',
        'projects.fourth_tag',
        'projects.first_image',
        'projects.second_image',
        'projects.third_image',
    ];

    /**
     * Retrieve a list of projects owned by the given user.
     *
     */
    public static function execute(User $user) : Paginator
    {
        return $user->projects()
            ->orderByDesc('id')
            ->simplePaginate(5, static::$fields);
    }
}
