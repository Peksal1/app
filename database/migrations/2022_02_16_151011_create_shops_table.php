<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('work_name');
            $table->longText('description');
            $table->foreignId('category_id')->references('id')->on('painting_categories')->onDelete('cascade');
            $table->string('file_path');
            $table->string('orientation');
            $table->foreignId('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreignId('paint_id')->references('id')->on('paints')->onDelete('cascade');
            $table->foreignId('canvas_id')->references('id')->on('canvases')->onDelete('cascade');
            $table->double('price_in_eur', 10, 2);
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
        Schema::dropIfExists('shops');
    }
}
