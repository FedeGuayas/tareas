<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned()->nullable();

            $table->string('email')->unique();
            $table->string('phone');
            $table->string('first_name');
            $table->string('last_name');
            
            $table->foreign('area_id')->references('id')->on('areas')
                ->onUpdate('cascade')->onDelete('no action');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('persons');
    }
}
