<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecepcionesMateriales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepciones_materiales', function (Blueprint $table) {
            $table->increments('rep_id');
            $table->integer('mat_id')->unsigned();
            $table->integer('rep_codigo');
            $table->string('rep_proveedor', 100)->nullable();
            $table->integer('rep_cantidad')->nullable();
            $table->integer('rep_monto_gastado')->nullable();
            $table->date('rep_fecha_compra')->nullable();
            $table->timestamps();

            $table->foreign('mat_id')->references('mat_id')->on('materiales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recepciones_materiales');
    }
}
