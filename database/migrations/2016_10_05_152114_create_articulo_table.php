<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->String('codigo_articulo',11);
            $table->integer('id_especifico');
            $table->integer('id_unidad_medida');            
            $table->string('nombre_articulo',100);
            $table->double('existencia',10,2)->default(0.0);
            $table->double('precio_unitario',10,2)->default(0.0);

            $table->timestamps();
            
            //Definicion de llave primaria
            $table->primary('codigo_articulo');
            
            // DEfinicion de llaves foraneas
            $table->foreign('id_especifico')->references('id')->on('especificos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_unidad_medida')->references('id_unidad_medida')->on('unidad_medida')->onDelete('restrict')->onUpdate('cascade');
            
            

            
        });
    }

    
    public function down()
    {
        Schema::table('articulo', function (Blueprint $table) {
            Schema::drop('articulo');
        });
    }
}