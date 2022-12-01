<?php

namespace App\Requests\Vacancy;

use App\Models\Vacancy;
use App\Types\FormRequest;

class ArchiveRequest extends FormRequest
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

        return user()->can('archive', $payload);
    }
}
