<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';
    protected $primaryKey = ['id_categoria'];
    //Especifica que no usa un entero autoincremental o numerico
   public $incrementing = true;

    protected $fillable = [
        'nombre','descripcion'
    ];

}
