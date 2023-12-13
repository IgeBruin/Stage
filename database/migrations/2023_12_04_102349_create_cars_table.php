<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string("title", 64);
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('fuel_id');
            $table->text('description');
            $table->unsignedInteger('year');
            $table->unsignedInteger('mileage');
            $table->date('mot');
            $table->unsignedInteger('price');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('fuel_id')->references('id')->on('fuels')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
