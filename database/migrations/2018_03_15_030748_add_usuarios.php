<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('usu_id');
            $table->integer('com_id')->unsigned();
            $table->integer('usu_rut')->unique();
            $table->string('usu_dv', 1);
            $table->string('usu_nombres', 100)->nullable();
            $table->string('usu_apellido_paterno', 50)->nullable();
            $table->string('usu_apellido_materno', 50)->nullable();
            $table->date('usu_fecha_nacimiento')->nullable();
            $table->string('usu_email', 200)->nullable();
            $table->integer('usu_telefono')->nullable();
            $table->string('usu_direccion', 200)->nullable();
            $table->string('usu_usuario', 30);
            $table->string('usu_password', 255);
            $table->enum('usu_rol',['Odontologo', 'Asistente', 'Administrador']);
            $table->string('remember_token', 100)->nullable()
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
        Schema::dropIfExists('usuarios');
    }
}
