<?php

namespace App\Rules;

use App\Types\Rule;

class LatitudeLongitudeRule extends Rule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return 'The :attribute must be valid, and must use 2 digits after the decimal point e.g. -77.03, 38.89';
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $latitude  = '[-]?((([0-8]?[0-9])(\.(\d{2}))?)|(90(\.0+)?))';
        $longitude = '[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{2}))?)|180(\.0+)?)';

        return preg_match("/^{$latitude},\s?{$longitude}$/", $value) > 0;
    }
}
