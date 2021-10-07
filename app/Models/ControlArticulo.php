<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class ControlArticulo extends Model
{
    protected $table='controlarticulo';
    protected $primaryKey = ['codigo_articulo','iddepartamento'];
    //Especifica que no usa un entero autoincremental o numerico
    public $incrementing = false;

    protected $fillable = [
        'codigo_articulo','iddepartamento','existencia','entregado'
    ];

    //relacion uno a muchos con especifico
    public function articulo(){

        return $this->belongsTo('sig\Models\Articulo','codigo_articulo','codigo_articulo');
    }

}
