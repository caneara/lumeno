<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class AvailableFilter implements Clause
{
    /**
     * Restrict the user list to workers that are available.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->where('users.available', true);
    }
}
