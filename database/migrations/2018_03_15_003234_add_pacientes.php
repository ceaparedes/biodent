<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPacientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('pac_id');
            $table->integer('com_id')->unsigned();
            $table->integer('pac_rut')->unique();
            $table->string('pac_dv');
            $table->string('pac_nombres', 100)->nullable();
            $table->string('pac_apellido_paterno', 50)->nullable();
            $table->string('pac_apellido_materno', 50)->nullable();
            $table->integer('pac_edad')->nullable();
            $table->date('pac_fecha_nacimiento')->nullable();
            $table->string('pac_direccion', 200)->nullable();
            $table->string('pac_email', 200)->nullable();
            $table->integer('pac_telefono')->nullable();
            $table->string('pac_motivo', 200)->nullable();
            $table->string('pac_observaciones', 250)->nullable();
            $table->timestamps();

            $table->foreign('com_id')->references('com_id')->on('comuna');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
