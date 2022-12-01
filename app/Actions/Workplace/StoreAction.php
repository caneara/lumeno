<?php

namespace App\Actions\Workplace;

use App\Models\User;
use App\Types\Action;
use App\Models\Workplace;

class StoreAction extends Action
{
    /**
     * Create a new workplace using the given user and payload.
     *
     */
    public static function execute(User $user, array $payload) : Workplace
    {
        return attempt(fn() => $user->workplaces()->create($payload));
    }
}
