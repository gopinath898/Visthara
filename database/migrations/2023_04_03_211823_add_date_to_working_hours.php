<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToWorkingHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('working_hour', function (Blueprint $table) {
            $table->date('booking_date');
        });

        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('license');
            $table->text('license')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('working_hour', function (Blueprint $table) {
            $table->dropColumn('booking_date');
            //
        });
    }
}
