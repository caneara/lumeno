<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Workplace\InteractsWithRelations;

class Workplace extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'          => 'string',
        'user_id'     => 'string',
        'employer'    => 'string',
        'location'    => 'string',
        'role'        => 'string',
        'summary'     => 'string',
        'started_at'  => 'date',
        'finished_at' => 'date',
    ];
}
