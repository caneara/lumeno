<?php

namespace App\Requests\Requirement;

use App\Types\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\MaxYearsExperienceRule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        $payload = [
            Requirement::class,
            organization(),
            $this->route('vacancy'),
        ];

        return user()->can('store', $payload);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $unique = Rule::unique('requirements')
            ->where('vacancy_id', $this->route('vacancy')->id);

        $years = MaxYearsExperienceRule::make($this->tool_id);

        return [
            'tool_id'  => ['bail', 'required', 'uuid', 'exists:tools,id', $unique],
            'years'    => ['bail', 'required', 'integer', 'min:1', $years],
            'optional' => 'bail|required|boolean',
            'summary'  => 'bail|nullable|string|max:200',
        ];
    }
}
