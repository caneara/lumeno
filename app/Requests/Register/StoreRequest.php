<?php

namespace App\Requests\Register;

use App\Types\FormRequest;
use App\Rules\ForbiddenDomainRule;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'name'     => 'bail|required|string|min:1|max:100',
            'email'    => ['bail', 'required', 'string', 'min:6', 'max:255', 'email', ForbiddenDomainRule::make(''), 'unique:users,email'],
            'password' => ['bail', 'required', 'string', 'max:255', 'confirmed', Password::defaults()],
            'handle'   => 'bail|required|string|min:4|max:100|unique:users,handle',
            'terms'    => 'bail|required|accepted|exclude',
        ];
    }
}
