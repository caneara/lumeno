<?php

namespace App\Actions\Vacancy;

use App\Models\User;
use App\Types\Action;
use App\Models\Vacancy;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Collections\CountryCollection;
use App\Collections\LanguageCollection;
use App\Collections\TimeZoneCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class ExportAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    public static array $fields = [
        ['header' => 'Name',            'column' => 'users.name'],
        ['header' => 'Profile',         'column' => 'users.handle'],
        ['header' => 'Country',         'column' => 'users.country'],
        ['header' => 'Area',            'column' => 'users.area'],
        ['header' => 'Time Zone',       'column' => 'users.time_zone'],
        ['header' => 'First Language',  'column' => 'users.first_language'],
        ['header' => 'Second Language', 'column' => 'users.second_language'],
        ['header' => 'Third Language',  'column' => 'users.third_language'],
        ['header' => 'Website',         'column' => 'users.website'],
        ['header' => 'Github',          'column' => 'users.github'],
        ['header' => 'Twitter',         'column' => 'users.twitter'],
        ['header' => 'Linkedin',        'column' => 'users.linkedin'],
        ['header' => 'Discord',         'column' => 'users.discord'],
        ['header' => 'Youtube',         'column' => 'users.youtube'],
        ['header' => 'Facebook',        'column' => 'users.facebook'],
        ['header' => 'Instagram',       'column' => 'users.instagram'],
    ];

    /**
     * Extract the given vacancy's invitations.
     *
     */
    public static function execute(Vacancy $vacancy) : void
    {
        $handle = fopen('php://output', 'w');

        fputcsv($handle, Arr::pluck(static::$fields, 'header'));

        static::query($vacancy)->chunk(100, function($users) use (&$handle) {
            $users->each(fn($user) => fputcsv($handle, static::format($user)));
        });

        fclose($handle);
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(User $user) : array
    {
        return [
            $user->name,
            route('account.show', $user->handle),
            CountryCollection::find($user->country)?->name ?? '',
            $user->area ?? '',
            TimeZoneCollection::find($user->time_zone)?->name ?? '',
            LanguageCollection::find($user->first_language)?->name ?? '',
            LanguageCollection::find($user->second_language)?->name ?? '',
            LanguageCollection::find($user->third_language)?->name ?? '',
            $user->website ?? '',
            static::link($user->github, 'https://github.com/XXX'),
            static::link($user->twitter, 'https://twitter.com/XXX'),
            static::link($user->linkedin, 'https://www.linkedin.com/in/XXX'),
            $user->discord ?? '',
            static::link($user->youtube, 'https://youtube.com/c/XXX'),
            static::link($user->facebook, 'https://www.facebook.com/XXX'),
            static::link($user->instagram, 'https://www.instagram.com/XXX'),
        ];
    }

    /**
     * Generate the headers used when streaming the export.
     *
     */
    public static function headers(Vacancy $vacancy) : array
    {
        return [
            'Content-type'          => 'text/csv',
            'Content-Disposition'   => "attachment; filename=" . Str::snake("{$vacancy->role}.csv"),
            'Pragma'                => 'no-cache',
            'Cache-Control'         => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'               => '0',
            'X-Vapor-Base64-Encode' => 'True',
        ];
    }

    /**
     * Generate an HTTP link to the given source using the given template.
     *
     */
    public static function link(mixed $source, string $template) : string
    {
        return filled($source) ? str_replace('XXX', $source, $template) : '';
    }

    /**
     * Construct the join clause between the users and the given vacancy.
     *
     */
    protected static function join(JoinClause $join, Vacancy $vacancy) : JoinClause
    {
        return $join->on('invitations.user_id', '=', 'users.id')
            ->where('invitations.vacancy_id', $vacancy->id);
    }

    /**
     * Generate a query to fetch the users that have been invited for the given vacancy.
     *
     */
    protected static function query(Vacancy $vacancy) : Builder
    {
        return User::query()
            ->join('invitations', fn($join) => static::join($join, $vacancy))
            ->select(Arr::pluck(static::$fields, 'column'))
            ->orderBy('invitations.id');
    }
}
