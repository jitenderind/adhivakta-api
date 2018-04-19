<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('caseId');
            $table->integer('forumId');
            $table->string('diaryNo',15)->nullable();
            $table->string('diaryDetail',100)->nullable();
            $table->string('caseType',10);
            $table->string('caseNo',5);
            $table->string('caseYear',4);
            $table->string('caseNoDetail',255)->nullable();
            $table->string('caseTitle',255)->nullable();
            $table->string('status',50)->nullable();
            $table->string('listing_details',255)->nullable();
            $table->date('nextListing')->nullable();
            $table->string('nextListingType',50)->nullable();
            $table->string('nextListingKind',50)->nullable();
            $table->string('nextListingCourt',255)->nullable();
            $table->string('nextListingCourtNo',3)->nullable();
            $table->string('nextListingItemNo',2)->nullable();
            $table->string('statusDetail',255)->nullable();
            $table->string('category',100)->nullable();
            $table->string('act',255)->nullable();
            $table->text('petitioner')->nullable();
            $table->text('respondent')->nullable();
            $table->string('p_advocate',255)->nullable();
            $table->string('r_advocate',255)->nullable();
            $table->string('courtNo',50)->nullable();
            $table->tinyInteger('updateFlag')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}
