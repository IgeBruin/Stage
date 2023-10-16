<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id')->cascadeOnDelete()->cascaadeOnUpdate();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
