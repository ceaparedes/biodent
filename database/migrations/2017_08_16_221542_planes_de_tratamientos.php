<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanesDeTratamientos extends Migration
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
            $table->integer('odo_id')->unsigned();
            $table->integer('pac_id')->unsigned();
            $table->integer('ept_id')->unsigned();
            $table->date('pdt_fecha_inicio');
            $table->date('pdt_fecha_termino');
            $table->string('pdt_detalle',250);
            $table->integer('pdt_costo_total_plan');
            //$table->integer('ept_costo_acumulado');

            $table->foreign('odo_id')->references('odo_id')->on('odontologos');
            $table->foreign('pac_id')->references('pac_id')->on('pacientes')->onDelete('cascade');
            $table->foreign('ept_id')->references('ept_id')->on('estados_planes_de_tratamientos');
            $table->timestamps();
        });

        Schema::create('plan_de_tratamiento_tratamiento', function (Blueprint $table) {
            $table->increments('ptt_id');
            $table->integer('pdt_id')->unsigned();
            $table->integer('tra_id')->unsigned();

            $table->foreign('pdt_id')->references('pdt_id')->on('planes_de_tratamientos');
            $table->foreign('tra_id')->references('tra_id')->on('tratamientos');

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
        Schema::dropIfExists('plan_de_tratamiento_tratamiento');
    }
}
