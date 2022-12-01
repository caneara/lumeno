<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Member\InteractsWithRole;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Member\InteractsWithRelations;

class Member extends Model
{
    use InteractsWithRole;
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The member roles.
     *
     */
    public const ROLE_MANAGER   = 1;
    public const ROLE_ASSOCIATE = 2;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'              => 'string',
        'organization_id' => 'string',
        'user_id'         => 'string',
        'role'            => 'integer',
    ];
}
