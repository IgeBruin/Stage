<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('type');
            $table->string('street');
            $table->string('street_number');
            $table->string('zip_code');
            $table->string('city');
            $table->string('name');
            $table->string('surname');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
