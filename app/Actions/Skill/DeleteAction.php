<?php

namespace App\Actions\Skill;

use App\Models\Skill;
use App\Types\Action;

class DeleteAction extends Action
{
    /**
     * Delete the given skill.
     *
     */
    public static function execute(Skill $skill) : void
    {
        attempt(fn() => $skill->delete());
    }
}
