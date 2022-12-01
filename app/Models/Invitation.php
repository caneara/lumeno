<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Invitation\InteractsWithRelations;

class Invitation extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'              => 'string',
        'organization_id' => 'string',
        'vacancy_id'      => 'string',
        'user_id'         => 'string',
        'sending_at'      => 'datetime',
        'sent_at'         => 'datetime',
    ];
}
