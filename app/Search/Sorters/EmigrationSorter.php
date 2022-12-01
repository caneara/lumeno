<?php

namespace App\Search\Sorters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class EmigrationSorter implements Clause
{
    /**
     * Order the user list by their country.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->when($vacancy->emigrate, function($query) use ($vacancy) {
            return $query->orderByRaw('FIELD(`users`.`country`, ?) DESC', [$vacancy->country]);
        });
    }
}
