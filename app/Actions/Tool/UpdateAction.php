<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;

class UpdateAction extends Action
{
    /**
     * Update the given tool using the given payload.
     *
     */
    public static function execute(Tool $tool, array $payload) : Tool
    {
        return attempt(fn() => tap($tool)->update($payload));
    }
}
