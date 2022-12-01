<?php

namespace App\Search\Sorters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class QualificationSorter implements Clause
{
    /**
     * Order the user list by their qualifications.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->orderByDesc('qualification');
    }
}
