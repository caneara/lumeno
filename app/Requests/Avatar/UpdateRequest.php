<?php

namespace App\Requests\Avatar;

use App\Types\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'avatar' => 'bail|required|image',
        ];
    }
}
