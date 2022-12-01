<?php

namespace App\Search\Contracts;

use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Builder;

interface Clause
{
    /**
     * Perform an action upon the given query.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder;
}
