<?php

namespace App\Requests\Vacancy;

use App\Types\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        $payload = [
            Vacancy::class,
            organization(),
            $this->route('vacancy'),
        ];

        return user()->can('edit', $payload);
    }
}
