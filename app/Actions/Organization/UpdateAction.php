<?php

namespace App\Actions\Organization;

use App\Types\Action;
use App\Models\Organization;

class UpdateAction extends Action
{
    /**
     * Update the given organization using the given payload.
     *
     */
    public static function execute(Organization $organization, array $payload) : Organization
    {
        return attempt(fn() => tap($organization)->update($payload));
    }
}
