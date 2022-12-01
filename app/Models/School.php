<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\School\InteractsWithRelations;

class School extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The qualification achievements.
     *
     */
    public const QUALIFICATION_STUDYING         = 1;
    public const QUALIFICATION_CERTIFICATE      = 2;
    public const QUALIFICATION_ASSOCIATE_DEGREE = 3;
    public const QUALIFICATION_BACHELOR_DEGREE  = 4;
    public const QUALIFICATION_MASTERS_DEGREE   = 5;
    public const QUALIFICATION_DOCTORAL_DEGREE  = 6;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'            => 'string',
        'user_id'       => 'string',
        'qualification' => 'integer',
        'name'          => 'string',
        'course'        => 'string',
        'location'      => 'string',
        'started_at'    => 'date',
        'finished_at'   => 'date',
    ];
}
