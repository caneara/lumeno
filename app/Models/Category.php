<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Category\InteractsWithRelations;

class Category extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'   => 'string',
        'name' => 'string',
    ];

    /**
     * Disable timestamps.
     *
     */
    public $timestamps = false;
}
