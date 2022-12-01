<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('users', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedTinyInteger('type');
            $table->string('name', 100)->index();
            $table->string('handle', 100)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->uuid('avatar')->nullable();
            $table->boolean('available')->default(false);
            $table->unsignedTinyInteger('country')->nullable();
            $table->string('area', 100)->nullable();
            $table->string('coordinates', 15)->nullable();
            $table->unsignedTinyInteger('time_zone')->nullable();
            $table->boolean('full_time')->nullable();
            $table->boolean('part_time')->nullable();
            $table->boolean('contract')->nullable();
            $table->unsignedTinyInteger('first_language')->nullable();
            $table->unsignedTinyInteger('second_language')->nullable();
            $table->unsignedTinyInteger('third_language')->nullable();
            $table->boolean('emigrate')->nullable();
            $table->unsignedTinyInteger('remote')->nullable();
            $table->unsignedTinyInteger('commute')->nullable();
            $table->unsignedTinyInteger('currency')->nullable();
            $table->unsignedMediumInteger('remuneration')->nullable();
            $table->string('website', 100)->nullable();
            $table->string('github', 50)->nullable();
            $table->string('twitter', 50)->nullable();
            $table->string('linkedin', 50)->nullable();
            $table->string('discord', 50)->nullable();
            $table->string('youtube', 50)->nullable();
            $table->string('facebook', 50)->nullable();
            $table->string('instagram', 50)->nullable();
            $table->text('statement')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->json('metrics')->default(DB::raw('(JSON_OBJECT())'));
            $table->rememberToken();
            $table->timestamps();

            foreach (['full_time', 'part_time', 'contract'] as $key) {
                $table->index($this->index($key), "users_résumé_{$key}_index");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('users');
    }

    /**
     * Generate the indexable columns along with the given field.
     *
     */
    protected function index(string $key) : array
    {
        return [
            'type',
            'available',
            $key,
            'remote',
            'country',
            'first_language',
            'second_language',
            'third_language',
            'remuneration',
            'id',
        ];
    }
}
