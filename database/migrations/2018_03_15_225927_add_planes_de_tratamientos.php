<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanesDeTratamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planes_de_tratamientos', function (Blueprint $table) {
            $table->increments('pdt_id');
            $table->integer('pac_id')->unsigned();
            $table->integer('usu_id')->unsigned();
            $table->integer('ept_id')->unsigned();
            $table->date('pdt_fecha_inicio')->nullable();
            $table->date('pdt_fecha_termino')->nullable();
            $table->string('pdt_detalle', 250)->nullable();
            $table->integer('pdt_costo_total');
            $table->timestamps();

            $table->foreign('pac_id')->references('pac_id')->on('pacientes')->onDelete('cascade');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
            $table->foreign('ept_id')->references('ept_id')->on('estados_planes_de_tratamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planes_de_tratamientos');
    }
}
