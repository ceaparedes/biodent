<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPiezasDentales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piezas_dentales', function (Blueprint $table) {
            $table->increments('pde_id');
            $table->string('pde_codigo_pieza', 3);
            $table->string('pde_nombre_pieza');
            $table->timestamps();
        });


        Schema::create('plan_pieza_dental', function(Blueprint $table){
            $table->increments('ppd_id');
            $table->integer('pde_id')->unsigned();
            $table->integer('pdt_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('piezas_dentales');
        Schema::dropIfExists('plan_pieza_dental');
    }
}
