<?php

namespace App\Concerns\Member;

use App\Models\Member;

trait InteractsWithRole
{
    /**
     * Determine if the member has the 'associate' role.
     *
     */
    public function isAssociate() : bool
    {
        return $this->role === Member::ROLE_ASSOCIATE;
    }

    /**
     * Determine if the member has the 'manager' role.
     *
     */
    public function isManager() : bool
    {
        return $this->role === Member::ROLE_MANAGER;
    }
}
