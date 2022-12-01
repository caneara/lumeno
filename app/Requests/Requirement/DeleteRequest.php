<?php

namespace App\Requests\Requirement;

use App\Types\FormRequest;
use App\Models\Requirement;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        $payload = [
            Requirement::class,
            organization(),
            $this->route('requirement'),
        ];

        return user()->can('delete', $payload);
    }
}
