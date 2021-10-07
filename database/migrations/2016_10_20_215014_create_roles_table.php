<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{

    public function up()
    {
       Schema::create('roles', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name',30)->unique();
            $table->string('description');
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
         Schema::drop('roles');
    }
}
