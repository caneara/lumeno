<?php

namespace App\Search\Filters;

use App\Models\User;
use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class LocationFilter implements Clause
{
    /**
     * Restrict the user list to workers with matching location attributes.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $remote   = $vacancy->remote ? 'Remote' : 'Office';
        $emigrate = $vacancy->emigrate ? 'international' : 'national';

        return static::{"{$emigrate}{$remote}Workers"}($query, $vacancy);
    }

    /**
     * Restrict candidates to international workers that will work at an office.
     *
     */
    protected static function internationalOfficeWorkers(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->where(function($query) use ($vacancy) {
            return $query->where(function($query) use ($vacancy) {
                return $query
                    ->tap(fn($query) => static::willEmigrate($query))
                    ->tap(fn($query) => static::willWorkAtOffice($query))
                    ->tap(fn($query) => static::withinDifferentCountry($query, $vacancy));
            })->orWhere(function($query) use ($vacancy) {
                return $query
                    ->tap(fn($query) => static::willWorkAtOffice($query))
                    ->tap(fn($query) => static::withinSameCountry($query, $vacancy))
                    ->tap(fn($query) => static::withinCommuteDistance($query, $vacancy));
            });
        });
    }

    /**
     * Restrict candidates to international workers that will work at home.
     *
     */
    protected static function internationalRemoteWorkers(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->tap(fn($query) => static::willWorkAtHome($query));
    }

    /**
     * Restrict candidates to national workers that will work at an office.
     *
     */
    protected static function nationalOfficeWorkers(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->where(function($query) use ($vacancy) {
            return $query
                ->tap(fn($query) => static::willWorkAtOffice($query))
                ->tap(fn($query) => static::withinSameCountry($query, $vacancy))
                ->tap(fn($query) => static::withinCommuteDistance($query, $vacancy));
        });
    }

    /**
     * Restrict candidates to national workers that will work at home.
     *
     */
    protected static function nationalRemoteWorkers(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->where(function($query) use ($vacancy) {
            return $query
                ->tap(fn($query) => static::willWorkAtHome($query))
                ->tap(fn($query) => static::withinSameCountry($query, $vacancy));
        });
    }

    /**
     * Eliminate workers that are not prepared to emigrate.
     *
     */
    protected static function willEmigrate(Builder $query) : Builder
    {
        return $query->where('users.emigrate', true);
    }

    /**
     * Eliminate workers that will only work remotely.
     *
     */
    protected static function willWorkAtOffice(Builder $query) : Builder
    {
        return $query->whereNot('users.remote', User::REMOTE_ONLY);
    }

    /**
     * Eliminate workers that will not work remotely.
     *
     */
    protected static function willWorkAtHome(Builder $query) : Builder
    {
        return $query->whereNot('users.remote', User::REMOTE_NO);
    }

    /**
     * Generate a SQL statement to restrict candidates based on commute distance.
     *
     */
    protected static function withinCommuteDistance(Builder $query, Vacancy $vacancy) : Builder
    {
        $location = $vacancy->coordinates;

        $sql = "DISTANCE('{$location}', `users`.`coordinates`) <= `users`.`commute`";

        return $query->whereRaw($sql);
    }

    /**
     * Eliminate workers that reside in the same country as the vacancy.
     *
     */
    protected static function withinDifferentCountry(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->whereNot('users.country', $vacancy->country);
    }

    /**
     * Eliminate workers that reside in a different country to the vacancy.
     *
     */
    protected static function withinSameCountry(Builder $query, Vacancy $vacancy) : Builder
    {
        return $query->where('users.country', $vacancy->country);
    }
}
