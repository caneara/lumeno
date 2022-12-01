<?php

namespace App\Rules;

use App\Types\Rule;
use Illuminate\Support\Facades\Storage;

class FileExistsRule extends Rule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return 'The file does not exist.';
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $path = ($this->parameters[0] ?? '')
              . $value
              . ($this->parameters[1] ?? '');

        return Storage::exists($path);
    }
}
