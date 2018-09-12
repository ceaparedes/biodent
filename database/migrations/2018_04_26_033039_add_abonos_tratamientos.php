<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbonosTratamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('abonos_tratamientos', function (Blueprint $table) {
            $table->increments('abt_id');
            $table->integer('pdt_id')->unsigned();
            $table->integer('pac_id')->unsigned();
            $table->date('abt_fecha');
            $table->integer('abt_monto_abonado');
            $table->timestamps();

            $table->foreign('pdt_id')->references('pdt_id')->on('planes_de_tratamientos')->onDelete('cascade');
            $table->foreign('pac_id')->references('pac_id')->on('pacientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonos_tratamientos');
    }
}
