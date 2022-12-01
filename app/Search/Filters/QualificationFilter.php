<?php

namespace App\Search\Filters;

use App\Models\School;
use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\EducationalQualificationCollection;

class QualificationFilter implements Clause
{
    /**
     * Restrict the user list to workers with a college degree.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        return $query
            ->addSelect(['qualification' => static::subQueryForQualification()])
            ->when($vacancy->degree, fn($query) => static::filter($query));
    }

    /**
     * Apply a constraint to only include users with degrees.
     *
     */
    protected static function filter(Builder $query) : Builder
    {
        $degrees = EducationalQualificationCollection::make()->onlyDegrees()->implode('id', ',');

        return $query->havingRaw("`qualification` IN ({$degrees})");
    }

    /**
     * Retrieve the highest qualification obtained by the user.
     *
     */
    protected static function subQueryForQualification() : Builder
    {
        return School::query()
            ->select(DB::raw('MAX(`qualification`)'))
            ->whereColumn('user_id', 'users.id')
            ->limit(1);
    }
}
