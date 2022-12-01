<?php

namespace App\Requests\Workplace;

use App\Models\Workplace;
use App\Types\FormRequest;
use App\Rules\BeforeWhenPresentRule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('store', Workplace::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'employer'    => 'bail|required|string|min:2|max:100',
            'location'    => 'bail|required|string|min:2|max:100',
            'role'        => 'bail|required|string|min:3|max:100',
            'summary'     => 'bail|required|string|min:30|max:500',
            'started_at'  => ['bail', 'required', 'date', BeforeWhenPresentRule::make('finished_at')],
            'finished_at' => 'bail|nullable|date|after:started_at',
        ];
    }
}
