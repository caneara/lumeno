<?php

namespace App\Requests\Account;

use App\Types\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * The fields to make available.
     *
     */
    public array $fields = [
        'name',
        'email',
        'avatar',
        'available',
        'country',
        'area',
        'coordinates',
        'time_zone',
        'full_time',
        'part_time',
        'contract',
        'first_language',
        'second_language',
        'third_language',
        'emigrate',
        'remote',
        'commute',
        'currency',
        'remuneration',
        'website',
        'github',
        'twitter',
        'linkedin',
        'discord',
        'youtube',
        'facebook',
        'instagram',
        'statement',
        'created_at',
    ];
}
