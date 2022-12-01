<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Project;

class ProjectPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given project.
     *
     */
    public function delete(User $user, Project $project) : bool
    {
        return $user->owns($project);
    }

    /**
     * Determine whether the given user can edit the given project.
     *
     */
    public function edit(User $user, Project $project) : bool
    {
        return $user->owns($project);
    }

    /**
     * Determine whether the given user can store projects.
     *
     */
    public function store(User $user) : bool
    {
        $current = $user->projects()->count();

        $limit = config('system.limits.projects');

        return $current < $limit;
    }

    /**
     * Determine whether the given user can update the given project.
     *
     */
    public function update(User $user, Project $project) : bool
    {
        return $user->owns($project);
    }
}
