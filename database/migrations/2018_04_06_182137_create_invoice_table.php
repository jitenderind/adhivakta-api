<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('invoiceId');
            $table->integer('userId');
            $table->string('invoice_no',30);
            $table->date('invoiceDate');
            $table->integer('userCaseId');
            $table->string('caseTitle');
            $table->float('invoice_amount',8,2);
            $table->text('invoice_details')->nullable();
            $table->tinyInteger('paid_status')->default(0);
            $table->string('note',100)->nullable();
            $table->string('paymentDetails',100)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
