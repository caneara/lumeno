<?php

namespace App\Jobs;

use App\Types\Job;
use App\Models\Tool;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PendingToolsNotification;

class NotifyPendingToolsJob extends Job
{
    /**
     * Execute the job.
     *
     */
    public function handle() : void
    {
        when($this->hasPendingTools(), fn() => $this->notifySupportTeam());
    }

    /**
     * Determine whether there are any pending tools.
     *
     */
    protected function hasPendingTools() : bool
    {
        return retry(4, fn() => Tool::where('approved', false)->exists(), 2500);
    }

    /**
     * Advise the support team that there are pending tools.
     *
     */
    protected function notifySupportTeam() : void
    {
        Notification::route('mail', config('mail.addresses.support'))
            ->notify(new PendingToolsNotification());
    }
}
