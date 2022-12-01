<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Skill;
use App\Types\Policy;

class SkillPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given skill.
     *
     */
    public function delete(User $user, Skill $skill) : bool
    {
        return $user->owns($skill);
    }

    /**
     * Determine whether the given user can set up their skills.
     *
     */
    public function setup(User $user) : bool
    {
        return $user->skills()->doesntExist();
    }

    /**
     * Determine whether the given user can store skills.
     *
     */
    public function store(User $user) : bool
    {
        $current = $user->skills()->count();

        $limit = config('system.limits.skills');

        return $current < $limit;
    }

    /**
     * Determine whether the given user can update the given skill.
     *
     */
    public function update(User $user, Skill $skill) : bool
    {
        return $user->owns($skill);
    }
}
