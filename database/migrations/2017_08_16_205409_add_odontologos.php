<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOdontologos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontologos', function (Blueprint $table) {
            $table->increments('odo_id');
            $table->integer('odo_rut');
            $table->char('odo_dv',1);
            $table->string('odo_nombres',100);
            $table->string('odo_apellido_paterno',50);
            $table->string('odo_apellido_materno',50);
            $table->date('odo_fecha_nacimiento');
            $table->string('odo_email',100);
            $table->string('odo_telefono',12);
            $table->string('odo_direccion',200);
            $table->string('odo_usuario',50);
            $table->string('odo_password',255);
            $table->enum('odo_rol', ['Usuario','Administrador']);
            $table->timestamps();
        });


        Schema::create('especialidad_odontologo', function (Blueprint $table) {
            $table->increments('eso_id');
            $table->integer('odo_id')->unsigned();
            $table->integer('esp_id')->unsigned();

            $table->foreign('odo_id')->references('odo_id')->on('odontologos');
            $table->foreign('esp_id')->references('esp_id')->on('especialidades');
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
        Schema::dropIfExists('odontologos');
        Schema::dropIfExists('especialidad_odontologo');
    }
}
