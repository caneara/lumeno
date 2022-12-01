<?php

namespace App\Rules;

use App\Types\Rule;
use Illuminate\Contracts\Validation\ImplicitRule;

class BlankRule extends Rule implements ImplicitRule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return 'The :attribute must be blank.';
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        return blank($value);
    }
}
