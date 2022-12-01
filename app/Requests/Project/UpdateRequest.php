<?php

namespace App\Requests\Project;

use App\Types\FormRequest;
use App\Rules\FileExistsRule;
use Illuminate\Validation\Rule;
use App\Collections\ProjectTypeCollection;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('update', $this->route('project'));
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $image = FileExistsRule::make('images/', '.jpg');

        $unique = Rule::unique('projects')
            ->ignoreModel($this->route('project'))
            ->where('user_id', user()->id);

        return [
            'type'         => ['bail', 'required', 'integer', ProjectTypeCollection::rule()],
            'logo'         => 'bail|nullable|image',
            'title'        => ['bail', 'required', 'string', 'min:4', 'max:100', $unique],
            'summary'      => 'bail|required|string|min:30|max:500',
            'url'          => 'bail|nullable|string|min:11|max:255|url',
            'first_tag'    => 'bail|nullable|string|min:2|max:20',
            'second_tag'   => 'bail|nullable|string|min:2|max:20',
            'third_tag'    => 'bail|nullable|string|min:2|max:20',
            'fourth_tag'   => 'bail|nullable|string|min:2|max:20',
            'first_image'  => ['bail', 'nullable', 'string', 'uuid', $image],
            'second_image' => ['bail', 'nullable', 'string', 'uuid', $image],
            'third_image'  => ['bail', 'nullable', 'string', 'uuid', $image],
        ];
    }
}
