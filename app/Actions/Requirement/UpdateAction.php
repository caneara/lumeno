<?php

namespace App\Actions\Requirement;

use App\Types\Action;
use App\Models\Requirement;

class UpdateAction extends Action
{
    /**
     * Update the given requirement using the given payload.
     *
     */
    public static function execute(Requirement $requirement, array $payload) : Requirement
    {
        return attempt(fn() => tap($requirement)->update($payload));
    }
}
