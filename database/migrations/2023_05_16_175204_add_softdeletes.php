<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftdeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('category', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('doctor', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('appointment', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('radiology_category', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('blog', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('subscription', function (Blueprint $table) {
            $table->integer('discount')->nullable();
            $table->softDeletes();
        });

        Schema::table('review', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('doctor_subscription', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
