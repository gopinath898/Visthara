<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('radiology_category', function (Blueprint $table) {
            $table->text('description');
        });

        Schema::table('subscription', function (Blueprint $table) {
            $table->text('description');
            $table->text('first_description');
            $table->integer('price')->default(0);
            $table->integer('duration')->default(0);
        });


        Schema::table('appointment', function (Blueprint $table) {
            $table->text('payment_id');
            $table->text('payment_order_id');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
