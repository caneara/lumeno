<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Models\Requirement;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class RequirementFilter implements Clause
{
    /**
     * Restrict the user list to workers with the required skills.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $vacancy->requirements->each(fn($item) => $query = static::join($item, $query));

        return $query;
    }

    /**
     * Apply the given requirement's constraints to the given join.
     *
     */
    protected static function filter(JoinClause $join, Requirement $requirement) : JoinClause
    {
        $table = "requirement_{$requirement->id}";

        return $join->on('users.id', '=', "{$table}.user_id")
            ->where("{$table}.tool_id", $requirement->tool_id)
            ->when(! $requirement->optional, function($query) use ($table, $requirement) {
                return $query->where("{$table}.years", '>=', $requirement->years);
            });
    }

    /**
     * Create a join for the given query using the given requirement.
     *
     */
    protected static function join(Requirement $requirement, Builder $query) : Builder
    {
        $table = "skills AS requirement_{$requirement->id}";

        $method = $requirement->optional ? 'leftJoin' : 'join';

        return $query->$method($table, fn($join) => static::filter($join, $requirement));
    }
}
