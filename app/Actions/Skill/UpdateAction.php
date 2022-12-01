<?php

namespace App\Actions\Skill;

use App\Models\Skill;
use App\Types\Action;

class UpdateAction extends Action
{
    /**
     * Update the given skill using the given payload.
     *
     */
    public static function execute(Skill $skill, array $payload) : Skill
    {
        return attempt(fn() => tap($skill)->update($payload));
    }
}
