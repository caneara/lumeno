<?php

namespace App\Requests\Register;

use Exception;
use App\Types\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        try {
            return $this->enlist();
        } catch (Exception) {
            return true;
        }
    }

    /**
     * Log the desire to enlist in an organization.
     *
     */
    protected function enlist() : bool
    {
        decrypt($this->route('enlist'));

        session()->put('enlist', $this->route('enlist'));

        return true;
    }
}
