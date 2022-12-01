<?php

namespace App\Actions\Skill;

use App\Models\User;
use App\Models\Skill;
use App\Types\Action;

class StoreAction extends Action
{
    /**
     * Create a new skill using the given user and payload.
     *
     */
    public static function execute(User $user, array $payload) : Skill
    {
        return attempt(fn() => $user->skills()->create($payload));
    }
}
