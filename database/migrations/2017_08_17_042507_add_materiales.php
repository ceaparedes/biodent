<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales', function (Blueprint $table) {
            $table->increments('mat_id');
            $table->integer('mat_codigo');
            $table->integer('mat_costo');
            $table->integer('mat_stock');
            $table->enum('mat_estado',['Disponible', 'Stock Crítico', 'Sin Stock']);
            $table->timestamps();
        });

        Schema::create('material_sesion', function (Blueprint $table) {
            $table->increments('mse_id');
            $table->integer('mat_id')->unsigned();
            $table->integer('set_id')->unsigned();

            $table->foreign('mat_id')->references('mat_id')->on('materiales');
            $table->foreign('set_id')->references('set_id')->on('sesiones_ejecucion_tratamientos');

            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materiales');
        Schema::dropIfExists('material_sesion');
    }
}
