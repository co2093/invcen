<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccion', function(Blueprint $table){
            $table->increments('id_transaccion');//Clave primiaria
            $table->integer('cantidad'); //Cantidad que entra o sale
            $table->double('pre_unit',10,2);//precio unitario nuevo
            $table->integer('exis_ant');//Existencia anterior
            $table->integer('exis_nueva');
            $table->date('fecha_registro');//Fecha que se realiza la transaccion
            $table->string('codigo_articulo',11);

            $table->timestamps();


            $table->foreign('codigo_articulo')->references('codigo_articulo')->on('articulo')->onDelete('restrict')->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaccion');
    }
}
