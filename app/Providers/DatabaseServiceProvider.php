<?php

namespace App\Providers;

use Bugsnag\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Database\Events\QueryExecuted;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot() : void
    {
        if (app()->isProduction()) {
            DB::whenQueryingForLongerThan(1000, function($connection, $event) {
                Bugsnag::notifyError(
                    'SlowDatabaseQueryError',
                    'The database query did not execute in a timely manner.',
                    fn($report) => $this->notify($report, $event)
                );
            });
        }
    }

    /**
     * Advise the error-management service of the given issue.
     *
     */
    protected function notify(Report $report, QueryExecuted $event) : void
    {
        $report->setSeverity('warning')->setMetaData([
            'query' => [
                'sql'      => $event->sql,
                'bindings' => $event->bindings,
            ],
        ]);
    }
}
