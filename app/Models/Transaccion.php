<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Transaccion extends Model
{
    protected $table = "transaccion";
    protected $primaryKey = "id_transaccion";
    public $incrementing = true;

    protected $fillable = [
        'cantidad','pre_unit','exis_ant','exis_nueva','fecha_registro','codigo_articulo'
    ];
    //cantidad --> cantidad
    //pre_unit --> precio unitario
    //exis_ant --> existencia anterior
    //exis_nueva --> existencia nueva
    //fecha_registro --> fecha en la que se registra la transaccion
    //codigo_articulo --> codigo de articulo

    public function getFecha(){
        $fecha = new Date($this->fecha_registro);
        return $fecha->format('d/m/Y');
    }
    //Relacion uchos a uno, indica que la transaccion esta asociado a un articulo
    public function articulo()
    {
        return $this->belongsTo('sig\Models\Articulo','codigo_articulo','codigo_articulo');
    }

    //Es usado si la transaccion es un ingreso o entrada
    public function ingreso(){
        return $this->hasOne('sig\Models\Ingreso','id_ingreso','id_transaccion');
    }

    //Es usado si la transaccion es un descargo o salida
    public function descargo(){
        return $this->hasOne('sig\Models\Descargo','id_descargo','id_transaccion');
    }

}
