<?php

namespace App\Kernels;

use App\Commands\SendInvitationsCommand;
use Illuminate\Foundation\Console\Kernel;
use App\Commands\FetchExchangeRatesCommand;
use App\Commands\NotifyPendingToolsCommand;
use Illuminate\Console\Scheduling\Schedule;

class Console extends Kernel
{
    /**
     * Register the commands for the application.
     *
     */
    protected function commands() : void
    {
        $this->load(app_path('Commands'));
    }

    /**
     * Define the application's command schedule.
     *
     */
    protected function schedule(Schedule $schedule) : void
    {
        $schedule->command('auth:clear-resets')->hourly();
        $schedule->command(SendInvitationsCommand::class)->everyMinute();
        $schedule->command(FetchExchangeRatesCommand::class)->daily();
        $schedule->command(NotifyPendingToolsCommand::class)->daily();
    }
}
