<?php

namespace App\Requests\Account;

use App\Types\FormRequest;
use App\Rules\ForbiddenDomainRule;
use App\Rules\LatitudeLongitudeRule;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use App\Collections\RemoteWorkingCollection;
use App\Collections\CommuteDistanceCollection;

class UpdateRequest extends FormRequest
{
    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [
            'name'            => 'bail|required|string|min:1|max:100',
            'email'           => ['bail', 'required', 'string', 'min:6', 'max:255', 'email', ForbiddenDomainRule::make(user()->email), 'unique:users,email,' . user()->id],
            'available'       => 'bail|required|boolean',
            'country'         => ['bail', 'nullable', 'integer', CountryCollection::rule()],
            'area'            => 'bail|nullable|string|min:2|max:100',
            'coordinates'     => ['bail', 'nullable', 'string', LatitudeLongitudeRule::make()],
            'time_zone'       => ['bail', 'nullable', 'integer', TimeZoneCollection::rule()],
            'full_time'       => 'bail|nullable|boolean',
            'part_time'       => 'bail|nullable|boolean',
            'contract'        => 'bail|nullable|boolean',
            'first_language'  => ['bail', 'nullable', 'integer', LanguageCollection::rule()],
            'second_language' => ['bail', 'nullable', 'integer', LanguageCollection::rule()],
            'third_language'  => ['bail', 'nullable', 'integer', LanguageCollection::rule()],
            'emigrate'        => 'bail|nullable|boolean',
            'remote'          => ['bail', 'nullable', 'integer', RemoteWorkingCollection::rule()],
            'commute'         => ['bail', 'nullable', 'integer', CommuteDistanceCollection::rule()],
            'currency'        => ['bail', 'nullable', 'integer', CurrencyCollection::rule()],
            'remuneration'    => 'bail|nullable|integer|min:1|max:10000000',
            'website'         => 'bail|nullable|string|min:11|max:100|url',
            'github'          => 'bail|nullable|string|min:3|max:50',
            'twitter'         => 'bail|nullable|string|min:3|max:50',
            'linkedin'        => 'bail|nullable|string|min:3|max:50',
            'discord'         => 'bail|nullable|string|min:3|max:50',
            'youtube'         => 'bail|nullable|string|min:3|max:50',
            'facebook'        => 'bail|nullable|string|min:3|max:50',
            'instagram'       => 'bail|nullable|string|min:3|max:50',
            'statement'       => 'bail|nullable|string|min:30|max:4000',
        ];
    }
}
