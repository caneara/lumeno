<?php

namespace App\Actions\Skill;

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
        'skills.id',
        'skills.tool_id',
        'skills.years',
        'skills.summary',
        'tools.name',
        'tools.approved',
        'tools.originated',
        'tools.category_id',
        'categories.name AS category',
    ];

    /**
     * Retrieve a list of the given user's skills.
     *
     */
    public static function execute(User $user) : Paginator
    {
        return $user->skills()
            ->join('tools', 'skills.tool_id', '=', 'tools.id')
            ->join('categories', 'tools.category_id', '=', 'categories.id')
            ->orderBy('tools.name')
            ->orderBy('categories.id')
            ->orderBy('tools.id')
            ->simplePaginate(10, static::$fields);
    }
}
