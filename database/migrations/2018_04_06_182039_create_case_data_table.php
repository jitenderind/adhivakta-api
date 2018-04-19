<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_data', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('caseDataId');
            $table->bigInteger('caseId');
            $table->date('data_date');
            $table->string('data_type',25);
            $table->text('data_value');
            $table->tinyInteger('updateFlag')->default(0);
            //$table->timestamps();
            //$table->foreign('caseId')->references('caseId')->on('cases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_data');
    }
}
