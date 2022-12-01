<?php

namespace Database\Factories;

use App\Models\User;
use App\Types\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     */
    public function definition() : array
    {
        $content = fake()->text(200) . "\n\n" .
                   fake()->text(200) . "\n\n" .
                   fake()->text(200);

        return [
            'user_id'    => User::factory(),
            'title'      => $title = fake()->text(50),
            'slug'       => Str::slug($title),
            'summary'    => fake()->text(300),
            'content'    => $content,
            'banner'     => uuid(),
            'first_tag'  => $this->randomTag(),
            'second_tag' => $this->randomTag(),
            'third_tag'  => $this->randomTag(),
            'fourth_tag' => $this->randomTag(),
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
