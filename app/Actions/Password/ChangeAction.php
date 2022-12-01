<?php

namespace App\Actions\Password;

use App\Models\User;
use App\Types\Action;

class ChangeAction extends Action
{
    /**
     * Update the given user's password to the given value.
     *
     */
    public static function execute(User $user, string $password) : void
    {
        attempt(fn() => $user->update(['password' => $password]));
    }
}
