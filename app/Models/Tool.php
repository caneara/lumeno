<?php

namespace App\Models;

use App\Types\Model;
use App\Casts\ReadOnlyJsonCast;
use App\Concerns\Shared\InteractsWithUuid;
use App\Concerns\Tool\InteractsWithRelations;

class Tool extends Model
{
    use InteractsWithUuid;
    use InteractsWithRelations;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'          => 'string',
        'category_id' => 'string',
        'name'        => 'string',
        'originated'  => 'integer',
        'approved'    => 'boolean',
        'metrics'     => ReadOnlyJsonCast::class,
    ];
}
