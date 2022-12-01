<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Requirement\InteractsWithRelations;

class Requirement extends Model
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
        'tool_id'         => 'string',
        'years'           => 'integer',
        'summary'         => 'string',
        'optional'        => 'boolean',
    ];
}
