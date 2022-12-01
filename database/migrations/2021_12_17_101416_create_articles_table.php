<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('articles', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 100);
            $table->string('slug', 125)->nullable()->index();
            $table->string('summary', 300);
            $table->mediumText('content');
            $table->uuid('banner')->nullable();
            $table->string('first_tag', 20)->nullable();
            $table->string('second_tag', 20)->nullable();
            $table->string('third_tag', 20)->nullable();
            $table->string('fourth_tag', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('articles');
    }
}
