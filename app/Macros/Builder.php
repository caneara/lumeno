<?php

namespace App\Macros;

use Illuminate\Database\Query\Builder as QueryFacade;
use Illuminate\Database\Eloquent\Builder as EloquentQueryFacade;

class Builder
{
    /**
     * Register the query builder macros.
     *
     */
    public static function macros() : void
    {
        static::third();
        static::filter();
        static::second();
        static::sortBy();
        static::toRawSql();
        static::whereLike();
    }

    /**
     * Strip all non-alphanumeric characters from the given value.
     *
     */
    public static function alphaNumeric(string $value) : string
    {
        return preg_replace("/[^[:alnum:][:space:]]/iu", '', $value);
    }

    /**
     * Register the 'filter' macro.
     *
     */
    protected static function filter() : void
    {
        QueryFacade::macro('filter', function($key, $payload, $closure) {
            $conditional = $payload[$key] ?? '';

            $conditional = is_bool($conditional) ? $conditional === true : filled($conditional);

            return $this->when($conditional, fn() => $closure($this, $payload[$key] ?? ''));
        });
    }

    /**
     * Register the 'second' macro.
     *
     */
    protected static function second() : void
    {
        EloquentQueryFacade::macro('second', function() {
            return $this->orderBy('id')->offset(1)->limit(1)->first();
        });
    }

    /**
     * Register the 'sort by' macro.
     *
     */
    protected static function sortBy() : void
    {
        QueryFacade::macro('sortBy', function($payload, $key, $direction = 'asc') {
            return $this->orderBy($payload['sort'] ?? $key, $payload['direction'] ?? $direction);
        });
    }

    /**
     * Register the 'third' macro.
     *
     */
    protected static function third() : void
    {
        EloquentQueryFacade::macro('third', function() {
            return $this->orderBy('id')->offset(2)->limit(1)->first();
        });
    }

    /**
     * Register the 'to raw SQL' macro.
     *
     */
    protected static function toRawSql() : void
    {
        QueryFacade::macro('toRawSql', function() {
            dd(vsprintf(str_replace(['?'], ['\'%s\''], $this->toSql()), $this->getBindings()));
        });
    }

    /**
     * Register the 'where like' macro.
     *
     */
    protected static function whereLike() : void
    {
        QueryFacade::macro('whereLike', function($key, $value = '') {
            return blank($value) ? $this : $this->where($key, 'LIKE', Builder::alphaNumeric($value) . '%');
        });
    }
}
