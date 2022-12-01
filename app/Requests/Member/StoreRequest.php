<?php

namespace App\Requests\Member;

use App\Models\Member;
use App\Rules\MissingRule;
use App\Types\FormRequest;
use App\Collections\MemberRoleCollection;

class StoreRequest extends FormRequest
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
        ];

        return user()->can('store', $payload);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $missing = MissingRule::make('users', 'email')
            ->join('members', 'members.user_id', 'users.id')
            ->setErrorMessage('The user is already a member of an organization');

        return [
            'email' => ['bail', 'required', 'string', 'min:6', 'max:255', 'email', $missing],
            'role'  => ['bail', 'required', 'integer', MemberRoleCollection::rule()],
        ];
    }
}
