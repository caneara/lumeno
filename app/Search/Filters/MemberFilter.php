<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class MemberFilter implements Clause
{
    /**
     * Restrict the user list to exclude members of the vacancy's organization.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query
            ->leftJoin('members', 'members.user_id', '=', 'users.id')
            ->where(fn($query) => static::filter($query, $vacancy));
    }

    /**
     * Apply a constraint to only include non members.
     *
     */
    protected static function filter(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query
            ->whereNull('members.organization_id')
            ->orWhereNot(fn($query) => $query->where('members.organization_id', $vacancy->organization_id));
    }
}
