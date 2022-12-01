<?php

namespace App\Actions\School;

use App\Types\Action;
use App\Models\School;

class DeleteAction extends Action
{
    /**
     * Delete the given school.
     *
     */
    public static function execute(School $school) : void
    {
        attempt(fn() => $school->delete());
    }
}
