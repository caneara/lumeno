<?php

namespace App\Requests\Member;

use App\Models\Member;
use App\Types\FormRequest;

class DeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        $payload = [
            Member::class,
            member(),
            organization(),
            $this->route('member'),
        ];

        return user()->can('delete', $payload);
    }
}
