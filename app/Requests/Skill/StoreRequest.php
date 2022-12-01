<?php

namespace App\Requests\Skill;

use App\Models\Skill;
use App\Rules\MissingRule;
use App\Types\FormRequest;
use App\Rules\MaxYearsExperienceRule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('store', Skill::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $missing = MissingRule::make('skills', 'tool_id')
            ->where('user_id', user()->id)
            ->setErrorMessage('This tool is already in your skill list');

        $years = MaxYearsExperienceRule::make($this->tool_id);

        return [
            'tool_id' => ['bail', 'required', 'uuid', 'exists:tools,id', $missing],
            'years'   => ['bail', 'required', 'integer', 'min:1', $years],
            'summary' => 'bail|nullable|string|max:200',
        ];
    }
}
