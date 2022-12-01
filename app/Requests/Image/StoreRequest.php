<?php

namespace App\Requests\Image;

use App\Rules\ImageRule;
use App\Types\FormRequest;
use App\Rules\FileExistsRule;

class StoreRequest extends FormRequest
{
    /**
     * Retrieve the image format to use.
     *
     */
    public function imageFormat() : string
    {
        return $this->format ?? 'general';
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        $image  = ImageRule::make('tmp/');
        $exists = FileExistsRule::make('tmp/');

        return [
            'format' => 'bail|nullable|string|in:general,social',
            'uuid'   => ['bail', 'required', 'string', 'uuid', $exists, $image],
        ];
    }
}
