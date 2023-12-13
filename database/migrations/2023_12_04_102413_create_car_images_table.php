<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarImagesTable extends Migration
{
    public function up()
    {
        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->string('image');
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_images');
    }
}
