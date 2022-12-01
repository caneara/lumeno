<?php

namespace App\Requests\Organization;

use App\Types\FormRequest;
use App\Models\Organization;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('delete', [Organization::class, member()]);
    }
}
