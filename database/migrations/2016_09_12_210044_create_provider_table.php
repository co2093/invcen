<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('direccion',100);
            $table->string('telefono',9);
            $table->string('fax',15)->nullable();
            $table->string('email',50)->nullable();
            $table->string('vendedor',60);

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
         Schema::drop('providers');
    }
}
