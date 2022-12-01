<?php

namespace App\Actions\School;

use App\Models\User;
use App\Types\Action;
use App\Models\School;

class StoreAction extends Action
{
    /**
     * Create a new school using the given user and payload.
     *
     */
    public static function execute(User $user, array $payload) : School
    {
        return attempt(fn() => $user->schools()->create($payload));
    }
}
