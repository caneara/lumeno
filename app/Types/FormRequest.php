<?php

namespace App\Types;

use Illuminate\Foundation\Http\FormRequest as Request;

class FormRequest extends Request
{
    /**
     * Ensure that the request returns all supplied data.
     *
     */
    public function all($keys = null) : array
    {
        $parameters = $this->route()?->parameters() ?? [];

        $parameters = array_replace_recursive($parameters, $this->query());

        return array_replace_recursive(parent::all($keys), $parameters);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return [];
    }
}
