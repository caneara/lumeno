<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Skill\InteractsWithRelations;

class Skill extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'      => 'string',
        'user_id' => 'string',
        'tool_id' => 'string',
        'years'   => 'integer',
        'summary' => 'string',
    ];
}
