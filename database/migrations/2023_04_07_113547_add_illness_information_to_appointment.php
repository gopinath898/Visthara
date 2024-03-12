<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIllnessInformationToAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->text('illness_information_taken')->nullable();
            $table->text('illness_exists')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('t&c_checked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn('illness_information_taken');
            $table->dropColumn('illness_exists');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('t&c_checked');
        });
    }
}
