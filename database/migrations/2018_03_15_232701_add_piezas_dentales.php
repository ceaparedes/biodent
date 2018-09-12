<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPiezasDentales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piezas_dentales', function (Blueprint $table) {
            $table->increments('pde_id');
            $table->string('pde_codigo_pieza', 20);
            $table->string('pde_nombre_pieza');
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
        Schema::dropIfExists('piezas_dentales');
        Schema::dropIfExists('plan_pieza_dental');
    }
}
