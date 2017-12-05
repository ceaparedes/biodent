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
            $table->integer('pac_rut');
            $table->char('pac_dv',1);
            $table->string('pac_nombres', 100);
            $table->string('pac_apellido_paterno', 50);
            $table->string('pac_apellido_materno',50);
            $table->integer('pac_edad');
            $table->string('pac_direccion', 200);
            $table->string('pac_telefono', 12);
            $table->string('pac_motivo', 200);
            $table->string('pac_observaciones', 200);
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
        Schema::dropIfExists('pacientes');
    }
}
