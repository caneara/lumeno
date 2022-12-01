<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('metrics', function(Blueprint $table) {
            $table->id();
            $table->string('table', 30);
            $table->string('name', 30);
            $table->string('value', 50);

            $table->unique(['table', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('metrics');
    }
}
