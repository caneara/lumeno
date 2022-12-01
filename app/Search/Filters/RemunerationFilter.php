<?php

namespace App\Search\Filters;

use App\Models\Vacancy;
use App\Search\Contracts\Clause;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class RemunerationFilter implements Clause
{
    /**
     * Restrict the user list to workers with matching financial expectations.
     *
     */
    public static function execute(Vacancy $vacancy, Builder $query) : Builder
    {
        $sql = '`users`.`remuneration` * `currencies`.`rate` <= ?';

        return $query
            ->join('currencies', 'users.currency', '=', 'currencies.id')
            ->whereRaw($sql, static::rate($vacancy));
    }

    /**
     * Calculate the exchange rate for the given vacancy's currency and remuneration.
     *
     */
    protected static function rate(Vacancy $vacancy) : array
    {
        $rate = DB::table('currencies')
            ->where('id', $vacancy->currency)
            ->value('rate');

        return [
            $vacancy->remuneration * $rate,
        ];
    }
}
