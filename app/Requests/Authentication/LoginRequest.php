<?php

namespace App\Requests\Authentication;

use App\Types\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'email'    => 'bail|required|string|min:6|max:255|email',
            'password' => 'bail|required|string|min:12|max:255',
            'remember' => 'bail|sometimes|boolean',
        ];
    }
}
