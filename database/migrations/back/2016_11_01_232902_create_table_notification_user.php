<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotificationUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('notification_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('notification_id')->references('id')->on('notifications')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'notification_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_user');
    }
}
