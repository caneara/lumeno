<?php

namespace App\Requests\Article;

use App\Types\FormRequest;
use App\Rules\FileExistsRule;

class StoreRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $image = FileExistsRule::make('images/', '.jpg');

        return [
            'banner'     => ['bail', 'nullable', 'string', 'uuid', $image],
            'title'      => 'bail|required|string|min:10|max:100',
            'summary'    => 'bail|required|string|min:30|max:300',
            'content'    => 'bail|required|string|min:200|max:2000000',
            'first_tag'  => 'bail|nullable|string|min:2|max:20',
            'second_tag' => 'bail|nullable|string|min:2|max:20',
            'third_tag'  => 'bail|nullable|string|min:2|max:20',
            'fourth_tag' => 'bail|nullable|string|min:2|max:20',
            'created_at' => 'bail|required|date',
        ];
    }
}
