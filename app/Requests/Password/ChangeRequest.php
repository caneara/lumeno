<?php

namespace App\Requests\Password;

use App\Types\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangeRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'old_password' => 'bail|required|string|min:12|max:255|current_password',
            'new_password' => ['bail', 'required', 'string', 'max:255', 'confirmed', Password::defaults()],
        ];
    }
}
