<?php

namespace App\Requests\Vacancy;

use App\Models\Vacancy;
use App\Rules\BlankRule;
use App\Types\FormRequest;
use App\Rules\LatitudeLongitudeRule;
use App\Collections\CountryCollection;
use App\Collections\CurrencyCollection;
use App\Collections\LanguageCollection;
use App\Collections\WorkCommitmentCollection;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('store', [Vacancy::class, member()]);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $months = $this->commitment === Vacancy::COMMITMENT_CONTRACT
            ? 'bail|required|integer|min:1|max:24'
            : ['bail', 'nullable', BlankRule::make()];

        return [
            'role'            => 'bail|required|string|min:4|max:100',
            'summary'         => 'bail|required|string|min:100|max:2000',
            'commitment'      => ['bail', 'required', 'integer', WorkCommitmentCollection::rule()],
            'months'          => $months,
            'currency'        => ['bail', 'required', 'integer', CurrencyCollection::rule()],
            'remuneration'    => 'bail|required|integer|min:1|max:10000000',
            'area'            => 'bail|required|string|min:2|max:100',
            'country'         => ['bail', 'required', 'integer', CountryCollection::rule()],
            'coordinates'     => ['bail', 'required', 'string', LatitudeLongitudeRule::make()],
            'first_language'  => ['bail', 'required', 'integer', LanguageCollection::rule()],
            'second_language' => ['bail', 'nullable', 'integer', LanguageCollection::rule()],
            'third_language'  => ['bail', 'nullable', 'integer', LanguageCollection::rule()],
            'remote'          => 'bail|required|boolean',
            'emigrate'        => 'bail|required|boolean',
            'degree'          => 'bail|required|boolean',
            'email'           => 'bail|required|string|min:6|max:255|email',
            'phone'           => 'bail|required|string|min:7|max:50|phone:AUTO',
            'website'         => 'bail|required|string|min:11|max:100|url',
        ];
    }
}
