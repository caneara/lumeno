<?php

namespace App\Requests\Tool;

use App\Types\FormRequest;
use Illuminate\Validation\Rule;
use App\Collections\ToolCategoryCollection;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('update', $this->route('tool'));
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $unique = Rule::unique('tools', 'name')
            ->where('category_id', $this->category_id)
            ->ignoreModel($this->route('tool'));

        return [
            'category_id' => ['bail', 'required', 'uuid', ToolCategoryCollection::rule()],
            'name'        => ['bail', 'required', 'string', 'min:1', 'max:60', $unique],
            'approved'    => 'bail|required|boolean',
            'originated'  => 'bail|required|integer|min:1940|max:' . now()->year,
        ];
    }
}
