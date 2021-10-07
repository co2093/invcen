<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicions', function (Blueprint $table) {
            $table->string('id',6);
            $table->string('estado',20);
            $table->date('fecha_solicitud')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->integer('departamento_id');            
            $table->string('observacion')->nullable(); 
            $table->string('financiero_id')->nullable();
            $table->string('bodega_id')->nullable();          
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('requisicions');
    }
}
