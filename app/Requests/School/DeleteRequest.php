<?php

namespace App\Requests\School;

use App\Types\FormRequest;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('delete', $this->route('school'));
    }
}
