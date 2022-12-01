<?php

namespace App\Actions\Skill;

use App\Models\User;
use App\Models\Skill;
use App\Types\Action;

class SetupAction extends Action
{
    /**
     * Create multiple skills for the given user using the given payload.
     *
     */
    public static function execute(User $user, array $payload) : void
    {
        attempt(fn() => Skill::insert($payload));
    }
}
