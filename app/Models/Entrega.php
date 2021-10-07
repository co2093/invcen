<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table='entrega';
    protected $primaryKey = 'identrega';

    protected $fillable = [
        'identrega','solicitante','descripcion','fechaentrega'
    ];

    //Relacion uno a muchos con DetalleEntrega
    public function detallesEntrega(){
        return $this->hasMany('sig\Models\DetalleEntrega','identrega');
    }
}
