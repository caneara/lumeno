<?php

namespace App\Search\Sorters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class DistanceSorter implements Clause
{
    /**
     * Order the user list by relative distance to the vacancy's location.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->orderBy('distance');
    }
}
