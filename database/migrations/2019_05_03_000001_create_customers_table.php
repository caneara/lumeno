<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        Schema::create('customers', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('billable_id');
            $table->string('billable_type');
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('pending_checkout_id')->nullable();
            $table->boolean('has_high_risk_payment')->default(false);
            $table->timestamps();

            $table->index(['billable_id', 'billable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        Schema::dropIfExists('customers');
    }
}
