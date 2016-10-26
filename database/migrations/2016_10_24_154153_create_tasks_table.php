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
            $table->integer('area_id')->unsigned()->nullable();
            $table->integer('person_id')->unsigned()->nullable();

            $table->string('task');
            $table->string('description')->nullable();
            $table->dateTime('start_day');
            $table->dateTime('performance_day');
            $table->dateTime('end_day')->nullable();
            $table->boolean('state');
            $table->boolean('allDay')->nullable();
            $table->string('color')->nullable();

            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('persons')
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
