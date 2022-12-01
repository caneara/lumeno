<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\School;

class SchoolPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given school.
     *
     */
    public function delete(User $user, School $school) : bool
    {
        return $user->owns($school);
    }

    /**
     * Determine whether the given user can store schools.
     *
     */
    public function store(User $user) : bool
    {
        $current = $user->schools()->count();

        $limit = config('system.limits.schools');

        return $current < $limit;
    }

    /**
     * Determine whether the given user can update the given school.
     *
     */
    public function update(User $user, School $school) : bool
    {
        return $user->owns($school);
    }
}
