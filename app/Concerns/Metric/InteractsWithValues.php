<?php

namespace App\Concerns\Metric;

use App\Models\Metric;

trait InteractsWithValues
{
    /**
     * Retrieve the value of the metric that has the given table and name.
     *
     */
    public static function value(string $table, string $name = 'count') : string
    {
        return Metric::query()
            ->where('table', $table)
            ->where('name', $name)
            ->value('value') ?? '';
    }
}
