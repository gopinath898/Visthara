<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportdata', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('data');
            $table->string('category_id');
            $table->timestamps();
        });

        Schema::table('pharmacy', function (Blueprint $table) {
            $table->text('low')->nullable();
            $table->text('moderate')->nullable();
            $table->text('high')->nullable();
            $table->text('short_desc')->nullable();
            $table->text('conditions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_document');
    }
}
