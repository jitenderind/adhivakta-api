<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal_alert', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('appealAlertId');
            $table->integer('userId');
            $table->integer('forumId');
            $table->string('court',50);
            $table->string('state',50);
            $table->string('case_no',30);
            $table->string('case_year',4);
            $table->date('date_of_judgement');
            $table->timestamps();
            
            //$table->foreign('forumId')->references('forumId')->on('forums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appeal_alert');
    }
}
