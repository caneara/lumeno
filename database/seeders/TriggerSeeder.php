<?php

namespace Database\Seeders;

use App\Types\Seeder;
use Triggers\Trigger;
use App\Models\Metric;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class TriggerSeeder extends Seeder
{
    /**
     * Seed the application database.
     *
     */
    public function run() : void
    {
        static::installTableCounter('tools');
        static::installTableCounter('users');
        static::installTableCounter('articles');
        static::installTableCounter('projects');
        static::installTableCounter('vacancies');
        static::installTableCounter('organizations');
        static::installTableCounter('subscriptions');

        static::installRelationCounter('users', [
            'articles'   => ['user_id'],
            'projects'   => ['user_id'],
            'schools'    => ['user_id'],
            'skills'     => ['user_id'],
            'workplaces' => ['user_id'],
        ]);

        static::installRelationCounter('tools', [
            'skills' => ['tool_id'],
        ]);

        static::installRelationCounter('organizations', [
            'members'   => ['organization_id'],
            'vacancies' => ['organization_id'],
        ]);

        static::installRelationCounter('vacancies', [
            'invitations' => ['vacancy_id'],
        ]);
    }

    /**
     * Add count metrics for the given relations of the given table.
     *
     */
    public static function installRelationCounter(string $table, array $relations) : void
    {
        foreach ($relations as $relation => $parameters) {
            $placeholders = [
                '{TABLE}'  => $table,
                '{ID}'     => $parameters[0],
                '{AND}'    => $parameters[1] ?? '',
                '{NAME}'   => Str::singular($relation),
            ];

            $sql = str_replace(
                array_keys($placeholders),
                array_values($placeholders),
                static::stub('relation-count')
            );

            Trigger::table($relation)->key($table)->afterInsert(function() use ($sql) {
                return str_replace(['{OPERATOR}', '{ROW}'], ['+', 'NEW'], $sql);
            });

            Trigger::table($relation)->key($table)->afterDelete(function() use ($sql) {
                return str_replace(['{OPERATOR}', '{ROW}'], ['-', 'OLD'], $sql);
            });
        }
    }

    /**
     * Add a count metric for the given table.
     *
     */
    public static function installTableCounter(string $table) : void
    {
        Metric::create([
            'table' => $table,
            'name'  => 'count',
            'value' => 0,
        ]);

        $placeholders = [
            '{TABLE}' => $table,
            '{NAME}'  => 'count',
        ];

        $sql = str_replace(
            array_keys($placeholders),
            array_values($placeholders),
            static::stub('table-count')
        );

        Trigger::table($table)->afterInsert(fn() => str_replace('{OPERATOR}', '+', $sql));
        Trigger::table($table)->afterDelete(fn() => str_replace('{OPERATOR}', '-', $sql));
    }

    /**
     * Retrieve the content of the given stub.
     *
     */
    public static function stub(string $name) : string
    {
        return File::get(database_path("stubs/{$name}.stub"));
    }
}
