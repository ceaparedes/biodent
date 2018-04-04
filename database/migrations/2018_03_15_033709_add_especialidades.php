<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEspecialidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidades', function (Blueprint $table) {
            $table->increments('esp_id');
            $table->string('esp_nombre', 100);
            $table->timestamps();
        });

        Schema::create('especialidad_usuario', function (Blueprint $table){
            $table->increments('esu_id');
            $table->integer('esp_id')->unsigned();
            $table->integer('usu_id')->unsigned();
            $table->timestamps();

            $table->foreign('usu_id')->references('usu_id')->on('usuarios')->onDelete('cascade');
            $table->foreign('esp_id')->references('esp_id')->on('especialidades');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('especialidad_usuario');
    }
}
