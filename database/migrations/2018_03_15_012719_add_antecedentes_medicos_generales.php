<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAntecedentesMedicosGenerales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('antecedentes_medicos_generales', function (Blueprint $table) {
            $table->increments('amg_id');
            $table->integer('pac_id')->unsigned();
            $table->integer('tan_id')->unsigned();
            $table->string('amg_descripcion', 250)->nullable();
            $table->timestamps();

            $table->foreign('pac_id')->references('pac_id')->on('pacientes')->onDelete('cascade');
            $table->foreign('tan_id')->references('tan_id')->on('tipos_antecedentes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antecedentes_medicos_generales');    
    }
}
