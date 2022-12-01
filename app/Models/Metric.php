<?php

namespace App\Models;

use App\Types\Model;
use App\Concerns\Metric\InteractsWithValues;

class Metric extends Model
{
    use InteractsWithValues;

    /**
     * The attributes that should be cast to specific types.
     *
     */
    protected $casts = [
        'id'    => 'integer',
        'table' => 'string',
        'name'  => 'string',
        'value' => 'string',
    ];

    /**
     * Disable timestamps.
     *
     */
    public $timestamps = false;
}
