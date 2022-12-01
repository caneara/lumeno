<?php

namespace App\Actions\Workplace;

use App\Types\Action;
use App\Models\Workplace;

class DeleteAction extends Action
{
    /**
     * Delete the given workplace.
     *
     */
    public static function execute(Workplace $workplace) : void
    {
        attempt(fn() => $workplace->delete());
    }
}
