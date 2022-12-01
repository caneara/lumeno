<?php

namespace App\Requests\Vacancy;

use App\Models\Vacancy;
use App\Types\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('view', [Vacancy::class, member()]);
    }

    /**
     * Retrieve the member permissions for the current user.
     *
     */
    public function permissions() : array
    {
        return [
            'create' => user()->can('create', [Vacancy::class, member()]),
        ];
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'role' => 'sometimes|nullable|bail|string|min:3|max:50',
        ];
    }
}
