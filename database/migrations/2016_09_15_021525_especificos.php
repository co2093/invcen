<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Especificos extends Migration
{
    public function up()
    {
       Schema::create('especificos', function (Blueprint $table) {
            $table->integer('id');
            $table->string('titulo_especifico',100);
            $table->text('descripcion_epecifico');
			//usado por laravel para la concurrencia
			
            $table->timestamps();
			$table->primary('id');
        });
    }
    
    public function down()
    {
        Schema::drop('especificos');
    }
}
