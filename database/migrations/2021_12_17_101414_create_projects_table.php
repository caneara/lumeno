<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('projects', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('type');
            $table->uuid('logo')->nullable();
            $table->string('title', 100)->index();
            $table->string('summary', 500);
            $table->string('url', 255)->nullable();
            $table->string('first_tag', 20)->nullable();
            $table->string('second_tag', 20)->nullable();
            $table->string('third_tag', 20)->nullable();
            $table->string('fourth_tag', 20)->nullable();
            $table->uuid('first_image')->nullable();
            $table->uuid('second_image')->nullable();
            $table->uuid('third_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('projects');
    }
}
