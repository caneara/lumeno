<?php

namespace App\Actions\Dashboard\Admin;

use App\Types\Action;
use App\Models\Metric;
use Illuminate\Support\Collection;

class MetricsAction extends Action
{
    /**
     * The required table metrics.
     *
     */
    protected static array $tables = [
        'users',
        'vacancies',
        'subscriptions',
        'organizations',
    ];

    /**
     * Retrieve the overall metrics for the application.
     *
     */
    public static function execute() : Collection
    {
        return Metric::query()
            ->where('name', 'count')
            ->whereIn('table', static::$tables)
            ->get()
            ->mapWithKeys(fn($item) => [$item['table'] => $item['value']]);
    }
}
