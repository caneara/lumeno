<?php

namespace App\Actions\Requirement;

use App\Types\Action;
use App\Models\Requirement;

class DeleteAction extends Action
{
    /**
     * Delete the given requirement.
     *
     */
    public static function execute(Requirement $requirement) : void
    {
        attempt(fn() => $requirement->delete());
    }
}
