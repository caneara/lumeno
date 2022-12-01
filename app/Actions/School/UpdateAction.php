<?php

namespace App\Actions\School;

use App\Types\Action;
use App\Models\School;

class UpdateAction extends Action
{
    /**
     * Update the given school using the given payload.
     *
     */
    public static function execute(School $school, array $payload) : School
    {
        return attempt(fn() => tap($school)->update($payload));
    }
}
