<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;

class DeleteAction extends Action
{
    /**
     * Delete the given tool.
     *
     */
    public static function execute(Tool $tool) : void
    {
        attempt(fn() => $tool->delete());
    }
}
