<?php

namespace App\Actions\Workplace;

use App\Models\User;
use App\Types\Action;
use Illuminate\Database\Eloquent\Collection;

class ViewAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'id',
        'employer',
        'location',
        'role',
        'summary',
        'started_at',
        'finished_at',
    ];

    /**
     * Retrieve a list of the given user's workplaces.
     *
     */
    public static function execute(User $user) : Collection
    {
        return $user->workplaces()
            ->get(static::$fields)
            ->sortByDesc('started_at')
            ->groupBy(fn($school) => $school->started_at->year);
    }
}
