<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('currencies', function(Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('symbol', 5);
            $table->string('name', 50);
            $table->string('rate', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('currencies');
    }
}
