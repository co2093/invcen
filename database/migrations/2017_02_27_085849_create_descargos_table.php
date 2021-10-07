<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescargosTable extends Migration
{
   
    public function up()
    {
        Schema::create('descargo', function(Blueprint $table){
           $table->integer('id_descargo');  //Clave primaria y foranea de transaccion
            $table->double('pre_unit_nuevo',10,2);   //Precio unitario nuevo

            $table->timestamps();
           //Clave primaria
           $table->primary('id_descargo');
           //Clave foranea
           $table->foreign('id_descargo')->references('id_transaccion')->on('transaccion')->onDelete('restrict')->onUpdate('cascade');
           $table->foreign('id_detalle')->references('id')->on('detalle_requisicions')->onDelete('restrict')->onUpdate('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('descargos');
    }
}
