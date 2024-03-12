<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLicenseToDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor', function (Blueprint $table) {
            $table->text('license');
            $table->text('company_name');
            $table->text('job_title');
            $table->text('location');
            $table->text('description');
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
            $table->dropColumn('license');
            $table->dropColumn('company_name');
            $table->dropColumn('job_title');
            $table->dropColumn('location');
            $table->dropColumn('description');
        });

    }
}
