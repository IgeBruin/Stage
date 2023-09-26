<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 64);
            $table->text('description');
            $table->date('deadline');
            $table->unsignedBigInteger('project_id');
            $table->enum('status', ['Niet gestart', 'In uitvoering', 'Voltooid'])->default('Niet gestart');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
