<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->datetime('start');
            $table->datetime('end')->nullable();
            $table->dateTime('end_day')->nullable()->default(null);//dia real de terminacion
            $table->boolean('state')->default(false);//estado de la tarea terminada 1, pendiente 0
            $table->mediumText('title')->nullable();
            $table->timestamps();
            
            $table->foreign('task_id')->references('id')->on('tasks')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
