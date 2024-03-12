<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMigrationsProductsclm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pharmacy', function (Blueprint $table) {
            $table->text('low')->nullable();
            $table->text('moderate')->nullable();
            $table->text('high')->nullable();
            $table->text('rec_low')->nullable();
            $table->text('rec_moderate')->nullable();
            $table->text('rec_high')->nullable();
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
        //
    }
}
