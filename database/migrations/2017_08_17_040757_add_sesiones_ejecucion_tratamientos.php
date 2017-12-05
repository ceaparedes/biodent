<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSesionesEjecucionTratamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones_ejecucion_tratamientos', function (Blueprint $table) {
            $table->increments('set_id');
            $table->integer('odo_id')->unsigned();
            $table->integer('tra_id')->unsigned();
            $table->integer('pdt_id')->unsigned();
            $table->integer('est_id')->unsigned();
            $table->date('set_fecha');
            $table->time('set_hora');
            $table->string('set_pieza_dental',100);
            $table->string('set_descripcion_sesion',250);

            $table->foreign('odo_id')->references('odo_id')->on('odontologos')->onDelete('cascade');
            $table->foreign('tra_id')->references('tra_id')->on('tratamientos')->onDelete('cascade');
            $table->foreign('pdt_id')->references('pdt_id')->on('planes_de_tratamientos')->onDelete('cascade');
            $table->foreign('est_id')->references('est_id')->on('estados_tratamientos');
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
        Schema::dropIfExists('sesiones_ejecucion_tratamientos');
    }
}
