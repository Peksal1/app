<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uuid');
            $table->foreignId('product_id')->references('id')->on('shops')->onDelete('cascade');
            $table->double('Price')->default(0);
            $table->string('status')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tnx_id')->nullable();
            $table->string('tracking_number')->default('Not yet available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
