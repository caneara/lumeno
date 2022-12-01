<?php

namespace App\Requests\Password;

use App\Types\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'token'    => 'bail|required|string',
            'email'    => 'bail|required|string|min:6|max:255|email',
            'password' => ['bail', 'required', 'string', 'max:255', 'confirmed', Password::defaults()],
        ];
    }
}
