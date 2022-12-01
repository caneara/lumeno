<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class AvatarFilter implements Clause
{
    /**
     * Restrict the user list to workers that have profile pictures.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query->whereNotNull('users.avatar');
    }
}
