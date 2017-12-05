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
            $table->integer('mat_codigo')->unsigned();
            $table->string('rep_proveedor',100);
            $table->integer('rep_cantidad');
            $table->string('rep_codigo_recepcion',100);
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
        Schema::dropIfExists('recepciones_materiales');
    }
}
