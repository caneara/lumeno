<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class InstallDistanceProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up() : void
    {
        DB::unprepared(file_get_contents(database_path('procedures/distance.sql')));
    }

    /**
     * Reverse the migrations.
     *
     */
    public function down() : void
    {
        DB::unprepared('DROP FUNCTION IF EXISTS distance');
    }
}
