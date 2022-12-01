<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('vacancies', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->string('role', 100);
            $table->string('summary', 2000);
            $table->unsignedTinyInteger('commitment');
            $table->unsignedTinyInteger('months')->nullable();
            $table->unsignedTinyInteger('currency');
            $table->unsignedMediumInteger('remuneration');
            $table->string('area', 100);
            $table->unsignedTinyInteger('country');
            $table->string('coordinates', 15);
            $table->unsignedTinyInteger('first_language');
            $table->unsignedTinyInteger('second_language')->nullable();
            $table->unsignedTinyInteger('third_language')->nullable();
            $table->boolean('remote');
            $table->boolean('emigrate');
            $table->boolean('degree');
            $table->string('email', 255);
            $table->string('phone', 50);
            $table->string('website', 100);
            $table->dateTime('archived_at')->nullable();
            $table->json('metrics')->default(DB::raw('(JSON_OBJECT())'));
            $table->timestamps();

            $table->index(['organization_id', 'role', 'archived_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('vacancies');
    }
}
