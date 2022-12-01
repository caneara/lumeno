<?php

namespace App\Actions\School;

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
        'qualification',
        'name',
        'course',
        'location',
        'started_at',
        'finished_at',
    ];

    /**
     * Retrieve a list of the given user's schools.
     *
     */
    public static function execute(User $user) : Collection
    {
        return $user->schools()
            ->get(static::$fields)
            ->sortByDesc('started_at')
            ->groupBy(fn($school) => $school->started_at->year);
    }
}
