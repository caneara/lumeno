<?php

namespace App\Search\Sorters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class IdSorter implements Clause
{
    /**
     * Order the user list by their identifier.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->orderByDesc('users.id');
    }
}
