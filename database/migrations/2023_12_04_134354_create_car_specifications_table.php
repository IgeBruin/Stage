<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarSpecificationsTable extends Migration
{
    public function up()
    {
        Schema::create('car_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('specification_id');
            $table->string('value')->nullable();
            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('specification_id')->references('id')->on('specifications')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['car_id', 'specification_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_specifications');
    }
}
