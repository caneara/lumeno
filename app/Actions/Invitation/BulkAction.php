<?php

namespace App\Actions\Invitation;

use App\Types\Action;
use App\Search\Engine;
use App\Models\Vacancy;
use App\Models\Organization;

class BulkAction extends Action
{
    /**
     * Send out multiple invitations for the given vacancy.
     *
     */
    public static function execute(Organization $organization, Vacancy $vacancy, int $limit) : int
    {
        $users = Engine::query($vacancy)
            ->whereNull('invitations.id')
            ->limit($limit)
            ->get()
            ->pluck('id');

        return StoreAction::execute($organization, $vacancy, $users);
    }
}
