<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('work_name');
            $table->string('file_path');
            $table->string('category');
            $table->foreignId('size_id')->references('id')->on('sizes')->onDelete('cascade');
            $table->foreignId('paint_id')->references('id')->on('paints')->onDelete('cascade');
            $table->foreignId('canvas_id')->references('id')->on('canvases')->onDelete('cascade');
            $table->foreignId('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->string('description');
            $table->boolean('available_in_digital');
            $table->string('digital_copy')->nullable();
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
        Schema::dropIfExists('portfolios');
    }
}
