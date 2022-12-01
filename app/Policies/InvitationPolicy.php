<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Search\Engine;
use App\Models\Vacancy;
use App\Models\Organization;

class InvitationPolicy extends Policy
{
    /**
     * Determine whether the given user can store multiple invitations.
     *
     */
    public function bulk(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        return $vacancy->isNotArchived() &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can store an invitation.
     *
     */
    public function store(User $user, Organization $organization, Vacancy $vacancy, User $candidate) : bool
    {
        return $vacancy->isNotArchived() &&
            $organization->owns($vacancy) &&
            Engine::canSendInvitation($candidate, $vacancy);
    }
}
