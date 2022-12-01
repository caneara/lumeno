<?php

namespace App\Requests\Invitation;

use App\Models\Invitation;
use App\Types\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        $payload = [
            Invitation::class,
            organization(),
            $this->route('vacancy'),
            $this->route('user'),
        ];

        return user()->can('store', $payload);
    }
}
