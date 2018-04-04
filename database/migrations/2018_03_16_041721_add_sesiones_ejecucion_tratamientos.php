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
            $table->integer('usu_id')->unsigned();
            $table->integer('tra_id')->unsigned();
            $table->integer('pde_id')->unsigned();
            $table->integer('pdt_id')->unsigned();
            $table->date('set_fecha')->nullable();
            $table->time('set_hora')->nullable();
            $table->string('set_descripcion_sesion', 200)->nullable();
            $table->timestamps();

            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
            $table->foreign('tra_id')->references('tra_id')->on('tratamientos');
            $table->foreign('pde_id')->references('pde_id')->on('piezas_dentales');
            $table->foreign('pdt_id')->references('pdt_id')->on('planes_de_tratamientos')->onDelete('cascade');
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
