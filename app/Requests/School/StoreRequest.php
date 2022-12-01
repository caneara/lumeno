<?php

namespace App\Requests\School;

use App\Models\School;
use App\Types\FormRequest;
use App\Rules\BeforeWhenPresentRule;
use App\Collections\EducationalQualificationCollection;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('store', School::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'qualification' => ['bail', 'required', 'integer', EducationalQualificationCollection::rule()],
            'name'          => 'bail|required|string|min:2|max:100',
            'course'        => 'bail|required|string|min:2|max:100',
            'location'      => 'bail|required|string|min:5|max:100',
            'started_at'    => ['bail', 'required', 'date', BeforeWhenPresentRule::make('finished_at')],
            'finished_at'   => 'bail|nullable|date|after:started_at',
        ];
    }
}
