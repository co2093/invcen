<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

use Jenssegers\Date\Date;


class Ingreso extends Model
{
    protected $table='ingreso';
	protected $primaryKey = 'id_ingreso';
	public $incrementing = false;

	protected $fillable = [
	    'id_ingreso','id_proveedor','pre_unit_nuevo','pre_unit_ant','orden','num_factura'];

	//id_ingreso --> identificador principal de ingreso es el mismo que el de la transaccion
    //id_proveedor --> identificador del proveedor
    //pre_unit_nuevo --> el precio unitario nuevo(el nuevo despues de haber ingresado la cantidad)
    //pre_unit_ant --> el precio que tenia antes de haber realizado la entrada
    //orden --> numero de orden
    //num_factura --> Numero de factura

	//Relacion uno a muchos con Provider
    public function proveedor()
    {
        return $this->belongsTo('sig\Models\Article\Provider','id_proveedor','id');
    }
    //Relacion uno a uno con tranccion
    public function transaccion(){
        return $this->belongsTo('sig\Models\Transaccion','id_ingreso','id_transaccion');
    }

    public function getMontoAnterior(){
        return $this->transaccion->exis_ant * $this->pre_unit_ant;
    }

    public function getMontoIngreso(){
        return $this->transaccion->cantidad * $this->transaccion->pre_unit;
    }

    public function getMontoNuevo(){
        return $this->transaccion->exis_nueva * $this->pre_unit_nuevo;
    }
	

}
