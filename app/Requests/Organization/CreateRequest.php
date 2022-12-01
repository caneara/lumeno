<?php

namespace App\Requests\Organization;

use App\Types\FormRequest;
use App\Models\Organization;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('create', [Organization::class, member()]);
    }
}
