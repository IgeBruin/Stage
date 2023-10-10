<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificationsTable extends Migration
{
    public function up()
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('specification_id');
            $table->string('value')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('specification_id')->references('id')->on('specifications')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            // dit heb je nodig blijkbaar
            $table->unique(['product_id', 'specification_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_specifications');
    }
}
