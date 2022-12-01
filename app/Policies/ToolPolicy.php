<?php

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;
use App\Types\Policy;

class ToolPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given tool.
     *
     */
    public function delete(User $user, Tool $tool) : bool
    {
        return $user->isEmployee();
    }

    /**
     * Determine whether the given user can search for tools.
     *
     */
    public function search(User $user) : bool
    {
        return true;
    }

    /**
     * Determine whether the given user can store tools.
     *
     */
    public function store(User $user) : bool
    {
        return true;
    }

    /**
     * Determine whether the given user can update the given tool.
     *
     */
    public function update(User $user, Tool $tool) : bool
    {
        return $user->isEmployee();
    }

    /**
     * Determine whether the given user can view any tools.
     *
     */
    public function view(User $user) : bool
    {
        return $user->isEmployee();
    }
}
