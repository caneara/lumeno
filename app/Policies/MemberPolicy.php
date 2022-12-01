<?php

namespace App\Policies;

use App\Models\User;
use App\Types\Policy;
use App\Models\Member;
use App\Models\Organization;

class MemberPolicy extends Policy
{
    /**
     * Determine whether the given user can delete the given member.
     *
     */
    public function delete(User $user, Member $member, Organization $organization, Member $item) : bool
    {
        return $member->isManager() &&
            $item->isNot($member) &&
            $organization->owns($item);
    }

    /**
     * Determine whether the given user can edit the given member.
     *
     */
    public function edit(User $user, Member $member, Organization $organization, Member $item) : bool
    {
        return $member->isManager() &&
            $item->isNot($member) &&
            $organization->owns($item);
    }

    /**
     * Determine whether the given user can store members.
     *
     */
    public function store(User $user, Member $member, Organization $organization) : bool
    {
        return $member->isManager();
    }

    /**
     * Determine whether the given user can update the given member.
     *
     */
    public function update(User $user, Member $member, Organization $organization, Member $item) : bool
    {
        return $member->isManager() &&
            $item->isNot($member) &&
            $organization->owns($item);
    }
}
