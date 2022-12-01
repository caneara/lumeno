<?php

namespace App\Actions\Member;

use App\Models\User;
use App\Types\Action;
use App\Models\Organization;

class EnlistAction extends Action
{
    /**
     * Assign the user to an organization if they are enlisting.
     *
     */
    public static function execute(User $user, string $payload = null) : void
    {
        if (blank($payload)) {
            return;
        }

        $payload = extract(decrypt($payload));

        StoreAction::execute(Organization::findOrFail($organization), $user->email, $role);
    }
}
