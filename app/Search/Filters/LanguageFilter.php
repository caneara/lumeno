<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Database\Eloquent\Builder;

class LanguageFilter implements Clause
{
    /**
     * Restrict the user list to workers with the required communication skills.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $first  = $vacancy->first_language;
        $second = $vacancy->second_language;
        $third  = $vacancy->third_language;

        return $query
            ->when($first, fn($query) => static::filter($query, $first))
            ->when($second, fn($query) => static::filter($query, $second))
            ->when($third, fn($query) => static::filter($query, $third));
    }

    /**
     * Apply a restriction to ensure that the worker is fluent with the given language.
     *
     */
    protected static function filter(Builder $query, int $language) : Builder
    {
        return $query->where(function($query) use ($language) {
            return $query->where('users.first_language', $language)
                ->orWhere('users.second_language', $language)
                ->orWhere('users.third_language', $language);
        });
    }
}
