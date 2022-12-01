<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Vacancy;
use App\Models\Requirement;
use App\Models\Organization;

class RequirementPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given requirement.
     *
     */
    public function delete(User $user, Organization $organization, Requirement $requirement) : bool
    {
        return $organization->owns($requirement);
    }

    /**
     * Determine whether the given user can store requirements for the given vacancy.
     *
     */
    public function store(User $user, Organization $organization, Vacancy $vacancy) : bool
    {
        $current = $vacancy->requirements()->count();

        $limit = config('system.limits.requirements');

        return ($current < $limit) &&
            $organization->owns($vacancy);
    }

    /**
     * Determine whether the given user can update the given requirement.
     *
     */
    public function update(User $user, Organization $organization, Requirement $requirement) : bool
    {
        return $organization->owns($requirement);
    }
}
