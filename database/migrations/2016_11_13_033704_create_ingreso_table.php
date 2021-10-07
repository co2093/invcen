<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoTable extends Migration
{
    
    public function up()
    {
       Schema::create('ingreso', function(Blueprint $table){
		   $table->integer('id_ingreso');                        //Clave primaria y foranea de transacion
		   $table->integer('id_proveedor');                      //Clave foranea  de proveedor

           $table->double('pre_unit_nuevo',10,2);   //Precio unitario nuevo
           $table->double('pre_unit_ant',10,2);     //Precio unitario anterior
           $table->string('orden',15);                   //Numero de orden
           $table->string('num_factura',10);                   //Numero de factura


           $table->timestamps();
		   //Clave primaria
           $table->primary('id_ingreso');
		   //Relaciones de clave foranea
           $table->foreign('id_proveedor')->references('id')->on('providers')->onDelete('restrict')->onUpdate('cascade');
		   $table->foreign('id_ingreso')->references('id_transaccion')->on('transaccion')->onDelete('restrict')->onUpdate('cascade');

		   
	   });
    }

    
    public function down()
    {
        Schema::drop('ingreso');
    }
}
