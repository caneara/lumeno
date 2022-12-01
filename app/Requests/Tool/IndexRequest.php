<?php

namespace App\Requests\Tool;

use App\Models\Tool;
use App\Types\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('view', Tool::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'name' => 'sometimes|nullable|bail|string|min:1|max:50',
        ];
    }
}
