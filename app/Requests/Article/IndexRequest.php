<?php

namespace App\Requests\Article;

use App\Types\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'title' => 'sometimes|nullable|bail|string|min:3|max:50',
        ];
    }
}
