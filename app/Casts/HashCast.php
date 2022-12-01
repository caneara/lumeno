<?php

namespace App\Casts;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;

class HashCast implements CastsInboundAttributes
{
    /**
     * Prepare the given value for storage.
     *
     */
    public function set($model, string $key, $value, array $attributes) : string | null
    {
        return $value ? Hash::make($value) : $value;
    }
}
