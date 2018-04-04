<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoletasServiciosPrestados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletas_servicios_prestados', function (Blueprint $table) {
            $table->increments('bsp_id');
            $table->integer('usu_id')->unsigned();
            $table->integer('bsp_monto_bruto')->nullable();
            $table->integer('bsp_monto_liquido')->nullable();
            $table->date('bsp_fecha')->nullable();
            $table->timestamps();

            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boletas_servicios_prestados');
    }
}
