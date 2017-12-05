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
            $table->integer('odo_id')->unsigned();
            $table->integer('bsp_monto_bruto');
            $table->integer('bsp_monto_liquido');
          //$table->date('bsp_fecha');

            $table->foreign('odo_id')->references('odo_id')->on('odontologos')->onDelete('cascade');
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
        Schema::dropIfExists('boletas_servicios_prestados');
    }
}
