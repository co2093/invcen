<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;
use sig\Models\ControlArticulo;

class DetalleEntrega extends Model
{
    protected $table='detalleentrega';
    protected $primaryKey = 'iddetalleentrega';

    protected $fillable = [
        'iddetalleentrega','codigo_articulo','iddepartamento','identrega','cantidadentregada'
    ];

}
