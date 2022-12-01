<?php

namespace App\Actions\Organization;

use App\Models\User;
use App\Types\Action;
use App\Models\Member;
use App\Models\Organization;
use App\Actions\Member\StoreAction as StoreMemberAction;

class StoreAction extends Action
{
    /**
     * Create a new organization using the given user and payload.
     *
     */
    public static function execute(User $user, array $payload) : Organization
    {
        $organization = attempt(fn() => Organization::create($payload));

        StoreMemberAction::execute($organization, $user->email, Member::ROLE_MANAGER);

        return $organization;
    }
}
