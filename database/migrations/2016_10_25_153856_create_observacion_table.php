<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionTable extends Migration
{
    
    public function up()
    {
		Schema::create('observacion', function (Blueprint $table) {
            $table->increments('id_obervacion');
            $table->string('descripcion_observacion');
            //usado por laravel para la concurrencia
			$table->timestamps();			
        });        
    }

    public function down()
    {
        Schema::drop('observacion');
    }
}
