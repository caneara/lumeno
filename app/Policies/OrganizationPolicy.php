<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Member;

class OrganizationPolicy extends Policy
{
    /**
     * Determine whether the given user can create an organization.
     *
     */
    public function create(User $user, Member $member = null) : bool
    {
        return ! $member;
    }

    /**
     * Determine whether the given user can delete the organization.
     *
     */
    public function delete(User $user, Member $member) : bool
    {
        return $member->isManager();
    }

    /**
     * Determine whether the given user can store an organization.
     *
     */
    public function store(User $user, Member $member = null) : bool
    {
        return ! $member;
    }

    /**
     * Determine whether the given user can update the organization.
     *
     */
    public function update(User $user, Member $member) : bool
    {
        return $member->isManager();
    }

    /**
     * Determine whether the given user can view the organization.
     *
     */
    public function view(User $user, Member $member = null) : bool
    {
        return ! ! $member;
    }
}
