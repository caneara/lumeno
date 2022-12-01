<?php

namespace App\Requests\Email;

use App\Types\FormRequest;

class VerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return hash_equals($this->route('id'), user()->id) &&
            hash_equals($this->route('hash'), sha1(user()->email));
    }
}
