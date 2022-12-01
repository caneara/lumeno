<?php

namespace App\Requests\Skill;

use App\Types\FormRequest;
use App\Rules\MaxYearsExperienceRule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('update', $this->route('skill'));
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $years = MaxYearsExperienceRule::make($this->route('skill')->tool_id);

        return [
            'years'   => ['bail', 'required', 'integer', 'min:1', $years],
            'summary' => 'bail|nullable|string|max:200',
        ];
    }
}
