<?php

namespace App\Requests\Invitation;

use App\Models\Invitation;
use App\Types\FormRequest;

class BulkRequest extends FormRequest
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
        ];

        return user()->can('bulk', $payload);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'limit' => 'bail|required|integer|min:1|max:100',
        ];
    }
}
