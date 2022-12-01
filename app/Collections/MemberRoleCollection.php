<?php

namespace App\Collections;

use App\Models\Member;
use App\Types\Collection;

class MemberRoleCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) [
                'id'      => Member::ROLE_MANAGER,
                'name'    => 'Manager',
                'color'   => 'orange',
                'icon'    => 'key',
                'summary' => 'Has complete access to all organization features',
            ],
            (object) [
                'id'      => Member::ROLE_ASSOCIATE,
                'name'    => 'Associate',
                'color'   => 'green',
                'icon'    => 'briefcase',
                'summary' => 'Access excludes billing and user management',
            ],
        ];
    }
}
