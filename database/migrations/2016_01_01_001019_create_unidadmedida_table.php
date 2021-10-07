<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadmedidaTable extends Migration
{
    
    public function up()
    {
       Schema::create('unidad_medida', function (Blueprint $table) {
            $table->increments('id_unidad_medida');
            $table->string('nombre_unidadmedida',100);
            //usado por laravel para la concurrencia
			$table->timestamps();
			//$table->primary('id_unidad_medida');
        });
    }

    public function down()
    {
        Schema::drop('unidad_medida');
    }
}
