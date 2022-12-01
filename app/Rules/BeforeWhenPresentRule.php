<?php

namespace App\Rules;

use App\Types\Rule;

class BeforeWhenPresentRule extends Rule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return "The :attribute must use a date before '{$this->parameters[0]}'.";
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        if (blank(request($this->parameters[0]))) {
            return true;
        }

        return strtotime($value) < strtotime(request($this->parameters[0]));
    }
}
