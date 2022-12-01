<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('requirements', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('vacancy_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('tool_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('years');
            $table->string('summary', 200)->nullable();
            $table->boolean('optional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('requirements');
    }
}
