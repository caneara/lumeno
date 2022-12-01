<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class LatitudeLongitudeCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     */
    public function get($model, string $key, $value, array $attributes) : string
    {
        return str_replace(',', ', ', $value);
    }

    /**
     * Prepare the given value for storage.
     *
     */
    public function set($model, string $key, $value, array $attributes) : mixed
    {
        return str_replace(' ', '', $value);
    }
}
