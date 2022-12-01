<?php

namespace App\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendInvitationsJob;

class SendInvitationsCommand extends Command
{
    /**
     * The command's name and signature.
     *
     */
    protected $signature = 'system:send-invitations';

    /**
     * The command's description.
     *
     */
    protected $description = 'Send a batch of pending invitations.';

    /**
     * Execute the console command.
     *
     */
    public function handle() : void
    {
        SendInvitationsJob::dispatch();

        $this->info('The invitations have been sent');
    }
}
