<?php

namespace App\Actions\Member;

use App\Types\Action;
use App\Models\Member;

class DeleteAction extends Action
{
    /**
     * Delete the given member.
     *
     */
    public static function execute(Member $member) : void
    {
        attempt(fn() => $member->delete());
    }
}
