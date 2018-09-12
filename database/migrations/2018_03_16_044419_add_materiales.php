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
            $table->string('mat_nombre_material');
            $table->integer('mat_costo');
            $table->integer('mat_stock');
            $table->integer('mat_stock_minimo');
            $table->date('mat_fecha_creacion')->nullable();
            $table->date('mat_fecha_actualizacion')->nullable();
            $table->enum('mat_estado',['Disponible', 'Stock Critico', 'Sin stock']);
            $table->timestamps();
        });

        Schema::create('material_sesion', function (Blueprint $table){
            $table->increments('mse_id');
            $table->integer('mat_id')->unsigned();
            $table->integer('set_id')->unsigned();
            $table->integer('mse_cantidad')->nullable();
            $table->timestamps();

            $table->foreign('mat_id')->references('mat_id')->on('materiales');
            $table->foreign('set_id')->references('set_id')->on('sesiones_ejecucion_tratamientos')->onDelete('cascade');
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
    }
}
