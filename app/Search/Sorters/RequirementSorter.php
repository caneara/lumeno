<?php

namespace App\Search\Sorters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class RequirementSorter implements Clause
{
    /**
     * Order the user list by their experience level.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $requirements = $vacancy->orderRequirementsByPriority()->requirements;

        $requirements->each(function($requirement) use (&$query) {
            $query = $query->orderByDesc("requirement_{$requirement->id}.years");
        });

        return $query;
    }
}
