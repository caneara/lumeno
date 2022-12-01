<?php

namespace App\Requests\Tool;

use App\Models\Tool;
use App\Types\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('search', Tool::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'exact'  => 'bail|required|boolean',
            'search' => 'bail|required|string|min:1|max:50',
            'page'   => 'bail|nullable|integer|min:1',
        ];
    }
}
