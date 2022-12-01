<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('schools', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('qualification');
            $table->string('name', 100);
            $table->string('course', 100);
            $table->string('location', 100);
            $table->date('started_at');
            $table->date('finished_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'qualification', 'finished_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('schools');
    }
}
