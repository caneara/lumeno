<?php

namespace App\Types;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

abstract class Job implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    /**
     * Delete the job if its models no longer exist.
     *
     */
    public bool $deleteWhenMissingModels = true;

    /**
     * The number of seconds the job can run before timing out.
     *
     */
    public int $timeout = 60;

    /**
     * The number of times the job may be attempted.
     *
     */
    public int $tries = 3;

    /**
     * Determine if the database is not available.
     *
     */
    protected function databaseUnavailable() : bool
    {
        try {
            return ! DB::connection()->getPdo();
        } catch (Exception) {
            return true;
        }
    }
}
