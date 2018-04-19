<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('taskId');
            $table->string('task',100);
            $table->integer('userId');
            $table->integer('parentUserId')->default(0);
            $table->integer('assignedTo');
            $table->integer('userCaseId')->default(0);
            $table->date('due_date');
            $table->tinyInteger('is_completed')->default(0);
            $table->timestamps();
            
            //$table->foreign('userCaseId')->references('userCaseId')->on('user_cases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
