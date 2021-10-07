<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Descargo extends Model
{
    protected $table='descargo';
	protected $primaryKey = 'id_descargo';
	public $incrementing = false;

	protected $fillable = [
	    'id_descargo,id_detalle,pre_unit_nuevo'];
	//id_descargo --> Es el identificador del descargo, es el mismo que el identificador de transaccion

    public function getMontoAnterior(){
        return $this->transaccion->pre_unit * $this->transaccion->exis_ant;
    }

    public function getMontoNuevo(){
        return $this->transaccion->exis_nueva * $this->transaccion->pre_unit;
    }

    public function getMontoDescargo(){
        return $this->transaccion->cantidad * $this->transaccion->pre_unit;
    }


    //Relacion uno a uno con transaccion
    public function transaccion(){
        return $this->belongsTo('sig\Models\Transaccion','id_descargo','id_transaccion');
    }

    //Relacion uno a uno con detalle de requisicion
    public function detalle(){
        return $this->belongsTo('sig\Models\DetalleRequisicion','id_detalle','id');
    }
}


