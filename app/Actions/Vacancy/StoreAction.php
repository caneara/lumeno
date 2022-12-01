<?php

namespace App\Actions\Vacancy;

use App\Types\Action;
use App\Models\Vacancy;
use App\Models\Organization;

class StoreAction extends Action
{
    /**
     * Create a new vacancy using the given payload.
     *
     */
    public static function execute(Organization $organization, array $payload) : Vacancy
    {
        return attempt(fn() => $organization->vacancies()->create($payload));
    }
}
