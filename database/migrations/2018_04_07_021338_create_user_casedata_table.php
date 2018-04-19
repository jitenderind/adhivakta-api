<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCasedataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_case_data', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('userCaseDataId');
            $table->bigInteger('userCaseId');
            $table->string('data_type',25);
            $table->text('data_value');
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
        Schema::dropIfExists('user_casedata');
    }
}
