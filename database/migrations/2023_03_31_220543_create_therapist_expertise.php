<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistExpertise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_expertise', function (Blueprint $table) {
            $table->id();
            $table->text('expertise_id'); 
            $table->unsignedBigInteger('doctor_user_id');
            $table->timestamps();
        });

        Schema::create('therapist_specialization', function (Blueprint $table) {
            $table->id();
            $table->text('specialisation_id'); 
            $table->unsignedBigInteger('doctor_user_id');
            $table->timestamps();
        });

        Schema::create('appointment_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_id');
            $table->string('session_name');
            $table->string('session_status');
            $table->timestamps();
        });

        Schema::table('doctor', function (Blueprint $table) {
            $table->string('cv_image');
            $table->string('id_proof');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapist_expertise');
        Schema::dropIfExists('appointment_sessions');
        Schema::dropIfExists('therapist_specialization');
    }
}
