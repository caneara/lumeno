<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\WorkCommitmentCollection;

class CommitmentFilter implements Clause
{
    /**
     * Restrict the user list to workers with a matching commitment level.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $commitment = WorkCommitmentCollection::find($vacancy->commitment);

        $field = (string) str($commitment->name)->snake()->prepend('users.');

        return $query->where($field, true);
    }
}
