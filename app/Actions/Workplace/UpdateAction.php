<?php

namespace App\Actions\Workplace;

use App\Types\Action;
use App\Models\Workplace;

class UpdateAction extends Action
{
    /**
     * Update the given workplace using the given payload.
     *
     */
    public static function execute(Workplace $workplace, array $payload) : Workplace
    {
        return attempt(fn() => tap($workplace)->update($payload));
    }
}
