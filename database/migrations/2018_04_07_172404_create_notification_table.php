<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('notificationId');
            $table->integer('userId');
            $table->dateTime('notificationDate');
            $table->string('notification');
            $table->tinyInteger('web_sent')->default(0);
            $table->tinyInteger('app_sent')->default(0);
            $table->tinyInteger('push_sent')->default(0);
            $table->tinyInteger('web_notified')->default(0);
            $table->tinyInteger('app_notified')->default(0);
            $table->tinyInteger('push_notified')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
