<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFullcalendareventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fullcalendareventos', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fechaIni');
            $table->datetime('fechaFin')->nullable();
            $table->boolean('todoeldia')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('titulo')->nullable();
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
        Schema::drop('fullcalendareventos');
    }
}
