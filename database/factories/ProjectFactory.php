<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;
use Illuminate\Support\Arr;
use App\Collections\ProjectTypeCollection;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        return [
            'user_id'      => User::factory(),
            'type'         => ProjectTypeCollection::make()->random()->id,
            'logo'         => uuid(),
            'title'        => fake()->text(50),
            'summary'      => fake()->text(300),
            'url'          => 'https://' . fake()->domainName(),
            'first_tag'    => $this->randomTag(),
            'second_tag'   => $this->randomTag(),
            'third_tag'    => $this->randomTag(),
            'fourth_tag'   => $this->randomTag(),
            'first_image'  => uuid(),
            'second_image' => uuid(),
            'third_image'  => uuid(),
        ];
    }

    /**
     * Retrieve a random of tag.
     *
     */
    protected function randomTag() : string
    {
        return Arr::random([
            'PHP',
            'Python',
            'JavaScript',
            'C#',
            'Laravel',
            'Django',
            'Node',
            'Vue',
            'React',
            'MySQL',
            'Postgres',
            'SQL Server',
            'Cecil',
            'Pizza',
            'Redcode',
            'Haxe',
            'Genie',
            'FP',
            'Kixtart',
            'Lingo',
            'Oriel',
            'SIGNAL',
            'DCL',
            'CSP',
            'LSL',
            'SenseTalk',
            'Java',
            'Octave',
        ]);
    }
}
