<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeUserTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('recipe_id')->references('id')->on('recipes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_user');
    }
}
