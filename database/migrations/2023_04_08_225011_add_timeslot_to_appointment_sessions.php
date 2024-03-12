<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeslotToAppointmentSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_sessions', function (Blueprint $table) {
            $table->date('session_date')->nullable();
            $table->string('session_timeslot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_sessions', function (Blueprint $table) {
            $table->dropColumn('session_timeslot');
            $table->dropColumn('session_date');
        });
    }
}
