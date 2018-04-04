<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTratamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->increments('tra_id');
            $table->string('tra_nombre');
            $table->string('tra_descripcion')->nullable();
            $table->integer('tra_costo');
            $table->timestamps();
        });


        Schema::create('plan_de_tratamiento_tratamiento', function(Blueprint $table){
            $table->increments('ptt_id');
            $table->integer('pdt_id')->unsigned();
            $table->integer('tra_id')->unsigned();
            $table->timestamps();

            $table->foreign('pdt_id')->references('pdt_id')->on('planes_de_tratamientos')->onDelete('cascade');
            $table->foreign('tra_id')->references('tra_id')->on('tratamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tratamientos');
        Schema::dropIfExists('plan_de_tratamiento_tratamiento');
    }
}
