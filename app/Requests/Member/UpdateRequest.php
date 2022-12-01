<?php

namespace App\Requests\Member;

use App\Types\FormRequest;
use App\Collections\MemberRoleCollection;

class UpdateRequest extends FormRequest
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

        return user()->can('update', $payload);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'role' => ['bail', 'required', 'integer', MemberRoleCollection::rule()],
        ];
    }
}
