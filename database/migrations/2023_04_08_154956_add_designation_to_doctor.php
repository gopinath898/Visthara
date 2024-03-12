<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignationToDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor', function (Blueprint $table) {
            $table->string('designation')->nullable();
            $table->string('title')->nullable();
            $table->string('firstName')->nullable();
            $table->string('middleName')->nullable();
            $table->string('lastName')->nullable();
            $table->dropColumn('experience');
            $table->dropColumn('company_name');
            $table->dropColumn('job_title');
            $table->dropColumn('location');
            $table->dropColumn('description');
            $table->text('experience_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor', function (Blueprint $table) {
            $table->dropColumn('designation');
            $table->dropColumn('title');
            $table->dropColumn('firstName');
            $table->dropColumn('middleName');
            $table->dropColumn('lastName');
            $table->dropColumn('experience_details');
            $table->text('company_name');
            $table->text('job_title');
            $table->text('location');
            $table->text('description');
            $table->integer('experience');
            $table->integer('duration');
        });
    }
}
