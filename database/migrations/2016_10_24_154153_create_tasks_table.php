<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->string('task');
            $table->longText('description')->nullable();
            $table->integer('created_by')->unsigned();
            $table->integer('weekday')->nullable();//1 Lun , 2 Martes etc.  0 si se repite el evento diario, por lo k no importaria en dia de la semana de comienzo del evento.
            $table->dateTime('start_day');
            $table->dateTime('performance_day');//dia planificado de terminar la tarea
            $table->dateTime('end_day')->nullable()->default(null);//dia real de terminacion
            $table->boolean('state')->default(false);//estado de la tarea cumplida 1, no cumplida 0
            $table->boolean('allDay')->nullable();
            $table->string('color')->nullable();
            $table->integer('repeats')->nullable();//1 para recurrentes, 0 no recurrente
            $table->integer('repeats_freq')->nullable();// 0 no recurrente, 1 diario, 7 semanal, 14 2semanas, 28 mensual, etc.
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')
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
        Schema::drop('tasks');
    }
}
