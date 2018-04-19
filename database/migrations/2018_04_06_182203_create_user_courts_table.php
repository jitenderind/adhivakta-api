<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('user_courts', function (Blueprint $table) {
            $table->increments('userCourtId');
            $table->integer('userCaseId');
            $table->integer('forumId');
            $table->string('courtOf',50);
            $table->string('courtNo',10);
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::dropIfExists('user_courts');
    }
}
