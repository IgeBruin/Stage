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
            $table->unsignedBigInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
