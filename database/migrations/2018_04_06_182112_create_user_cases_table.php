<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('userCaseId');
            $table->integer('userId');
            $table->bigInteger('caseId');
            $table->string('fileNo',20);
            $table->string('caseTitle',100)->nullable();
            $table->integer('forumId');
            $table->string('client_name',50)->nullable();
            $table->string('client_email',50)->nullable();
            $table->string('client_phone',33)->nullable();
            $table->string('client_address',255)->nullable();
            $table->string('opp_counsel_name',50)->nullable();
            $table->string('opp_counsel_email',50)->nullable();
            $table->string('opp_counsel_phone',33)->nullable();
            $table->string('opp_counsel_address',255)->nullable();
            $table->tinyInteger('is_archived')->default(0);
            $table->timestamps();
            
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
        Schema::dropIfExists('user_cases');
    }
}
