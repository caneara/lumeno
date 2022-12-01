<?php

namespace App\Requests\Skill;

use App\Models\Tool;
use App\Models\Skill;
use App\Types\FormRequest;
use Illuminate\Support\Arr;
use App\Collections\YearsExperienceCollection;

class SetupRequest extends FormRequest
{
    /**
     * The exact names for default list of tools.
     *
     */
    protected array $tools = [
        'javascript' => 'JavaScript',
        'php'        => 'PHP',
        'python'     => 'Python',
        'csharp'     => 'C#',
        'css'        => 'CSS',
        'html'       => 'HTML',
        'java'       => 'Java',
        'vue'        => 'Vue (JavaScript)',
        'react'      => 'React (JavaScript)',
        'swift'      => 'Swift',
        'mysql'      => 'MySQL',
        'postgres'   => 'PostgreSQL',
        'figma'      => 'Figma',
        'sketch'     => 'Sketch',
        'docker'     => 'Docker',
        'aws'        => 'Amazon Web Services (AWS)',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize() : bool
    {
        return user()->can('setup', Skill::class);
    }

    /**
     * Retrieve the validation rules that apply to the request.
     *
     */
    public function rules() : array
    {
        return Arr::map($this->tools, function() {
            return ['bail', 'nullable', 'integer', YearsExperienceCollection::rule()];
        });
    }

    /**
     * Retrieve the validated data from the request.
     *
     */
    public function validated($key = null, $default = null) : mixed
    {
        $tools = Tool::whereIn('name', $this->tools)->get(['id', 'name']);

        $data = array_filter(parent::validated());

        return Arr::map($data, function($item, $key) use ($tools) {
            return [
                'id'         => uuid(),
                'user_id'    => user()->id,
                'tool_id'    => $tools->firstWhere('name', $this->tools[$key])->id,
                'years'      => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}
