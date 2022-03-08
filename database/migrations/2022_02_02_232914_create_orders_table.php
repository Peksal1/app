<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('completion')->default(0);
            $table->boolean('accepted')->default(0);
            $table->string('file_path')->nullable();
            $table->string('size');
            $table->string('paint');
            $table->string('canvas');
            $table->double('price')->default(0);
            $table->boolean('is_paid')->default(0);
            $table->longText('text');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
