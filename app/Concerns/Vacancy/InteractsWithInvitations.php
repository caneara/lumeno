<?php

namespace App\Concerns\Vacancy;

trait InteractsWithInvitations
{
    /**
     * Determine if no invitations have been sent for the vacancy.
     *
     */
    public function hasNotSentInvitations() : bool
    {
        return ! $this->hasSentInvitations();
    }

    /**
     * Determine if any invitations have been sent for the vacancy.
     *
     */
    public function hasSentInvitations() : bool
    {
        return ($this->metrics->invitation_count ?? 0) > 0;
    }
}
