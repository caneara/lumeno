<?php

namespace App\Actions\Vacancy;

use App\Types\Action;
use App\Models\Vacancy;

class DeleteAction extends Action
{
    /**
     * Delete the given vacancy.
     *
     */
    public static function execute(Vacancy $vacancy) : void
    {
        attempt(fn() => $vacancy->delete());
    }
}
