<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Workplace;

class WorkplacePolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given workplace.
     *
     */
    public function delete(User $user, Workplace $workplace) : bool
    {
        return $user->owns($workplace);
    }

    /**
     * Determine whether the given user can store workplaces.
     *
     */
    public function store(User $user) : bool
    {
        $current = $user->workplaces()->count();

        $limit = config('system.limits.workplaces');

        return $current < $limit;
    }

    /**
     * Determine whether the given user can update the given workplace.
     *
     */
    public function update(User $user, Workplace $workplace) : bool
    {
        return $user->owns($workplace);
    }
}
