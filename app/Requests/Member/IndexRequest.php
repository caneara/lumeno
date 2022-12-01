<?php

namespace App\Requests\Member;

use App\Types\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return ! ! member();
    }

    /**
     * Retrieve the member permissions for the current user.
     *
     */
    public function permissions() : array
    {
        return [
            'create' => member()->isManager(),
        ];
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'name' => 'sometimes|nullable|bail|string|min:3|max:50',
        ];
    }
}
