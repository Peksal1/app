<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();   
            $table->string('uuid');
            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->double('Price')->default(0);
            $table->string('status')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tnx_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_purchases');
    }
}
