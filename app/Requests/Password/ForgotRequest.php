<?php

namespace App\Requests\Password;

use App\Types\FormRequest;

class ForgotRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'email' => 'bail|required|string|min:6|max:255|email',
        ];
    }
}
