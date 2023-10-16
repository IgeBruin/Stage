<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientsTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('ingredient_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50);
            $table->timestamps();
            
            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_ingredients');
    }
}
