<?php

namespace App\Rules;

use App\Types\Rule;
use Illuminate\Support\Facades\Storage;

class ImageRule extends Rule
{
    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return 'The image is not a JPEG or PNG, or it is greater than 3 MB in size.';
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $path = ($this->parameters[0] ?? '') . $value;

        if (Storage::size($path) > 3145728) {
            return false;
        }

        if (! in_array(Storage::mimeType($path), ['image/jpeg', 'image/png'])) {
            return false;
        }

        return true;
    }
}
