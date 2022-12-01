<?php

namespace App\Requests\Organization;

use App\Types\FormRequest;
use App\Models\Organization;
use App\Rules\ForbiddenDomainRule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('store', [Organization::class, member()]);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'name'    => 'bail|required|string|min:1|max:100',
            'email'   => ['bail', 'required', 'string', 'min:6', 'max:255', 'email', ForbiddenDomainRule::make(''), 'unique:organizations,email'],
            'phone'   => 'bail|required|string|min:7|max:50|phone:AUTO',
            'website' => 'bail|required|string|min:11|max:100|url',
        ];
    }
}
