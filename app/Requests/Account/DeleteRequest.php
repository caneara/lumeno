<?php

namespace App\Requests\Account;

use App\Types\FormRequest;

class DeleteRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'password' => 'bail|required|string|min:12|max:255|current_password',
        ];
    }
}
