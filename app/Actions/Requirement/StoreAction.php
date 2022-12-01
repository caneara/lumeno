<?php

namespace App\Actions\Requirement;

use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Requirement;

class StoreAction extends Action
{
    /**
     * Store a new requirement for the given vacancy.
     *
     */
    public static function execute(Vacancy $vacancy, array $payload) : Requirement
    {
        $payload['organization_id'] = $vacancy->organization_id;

        return attempt(fn() => $vacancy->requirements()->create($payload));
    }
}
