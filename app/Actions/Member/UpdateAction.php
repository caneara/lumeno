<?php

namespace App\Actions\Member;

use App\Types\Action;
use App\Models\Member;

class UpdateAction extends Action
{
    /**
     * Assign the given role to the given member.
     *
     */
    public static function execute(Member $member, int $role) : Member
    {
        return attempt(fn() => tap($member)->update(['role' => $role]));
    }
}
