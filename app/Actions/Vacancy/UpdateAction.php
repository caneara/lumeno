<?php

namespace App\Actions\Vacancy;

use App\Types\Action;
use App\Models\Vacancy;

class UpdateAction extends Action
{
    /**
     * Update the given vacancy using the given payload.
     *
     */
    public static function execute(Vacancy $vacancy, array $payload) : Vacancy
    {
        return attempt(fn() => tap($vacancy)->update($payload));
    }
}
