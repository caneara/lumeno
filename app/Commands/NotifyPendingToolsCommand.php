<?php

namespace App\Commands;

use Illuminate\Console\Command;
use App\Jobs\NotifyPendingToolsJob;

class NotifyPendingToolsCommand extends Command
{
    /**
     * The command's name and signature.
     *
     */
    protected $signature = 'system:notify-pending-tools';

    /**
     * The command's description.
     *
     */
    protected $description = 'Notify the administrator of any tools that are pending';

    /**
     * Execute the console command.
     *
     */
    public function handle() : void
    {
        NotifyPendingToolsJob::dispatch();

        $this->info('The administrator has been notified');
    }
}
