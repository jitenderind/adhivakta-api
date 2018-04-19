<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('caseTypeId');
            $table->integer('forumId');
            $table->string('caseType',80);
            $table->string('abbr',80);
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
        Schema::dropIfExists('case_types');
    }
}
