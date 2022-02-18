<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
           
            $table->foreignId('purchase_id ')->references('id')->on('purchases')->onDelete('cascade');
            $table->string('name');
            $table->string('surname');
            $table->string('phone_number');
            $table->string('email');
            $table->string('country');
            $table->string('city');
            $table->string('adress1');
            $table->string('adress2');
            $table->string('postal_code');
            $table->timestamps();
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
