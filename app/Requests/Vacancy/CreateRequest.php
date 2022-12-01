<?php

namespace App\Requests\Vacancy;

use App\Models\Vacancy;
use App\Types\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('create', [Vacancy::class, member()]);
    }
}
