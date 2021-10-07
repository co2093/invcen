<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Requisicion extends Model
{
    protected $table = 'requisicions';
    protected $primaryKey = 'id';
 

    protected $fillable=[
    	'id' ,'estado','departamento_id','fecha_solicitud','fecha_entrega','total','observacion','financiero_id','bodega_id','ordenrequisicion',
    ];


   public function departamento(){
		return $this->belongsTo('sig\Models\Department','departamento_id','id');
	}

    public function bodega(){
        return $this->hasOne('sig\User','id','bodega_id');
    }
    public function financiero(){
        return $this->hasOne('sig\User','id','financiero_id');
    }

	public function detalles(){
    	return $this->hasMany('sig\Models\DetalleRequisicion','requisicion_id');		
	}

    public function getNumero(){
        $date = new Date($this->fecha_entrega);
        $numero = substr($this->id,2).'/'.$date->format('Y');
        return $numero;
    }

    public function getFechaSolicitud(){
        $fecha = new Date($this->fecha_solicitud);
        return $fecha->format('d/m/Y');
    }

    public function getMonto(){
        $monto = 0.0000;
        foreach ($this->detalles as $d ){
            $monto = $monto + $d->getMonto();
        }
        return $monto;
    }

    public function getFechaEntrega(){
        $fecha = new Date($this->fecha_entrega);
        return $fecha->format('d/m/Y');
    }


}
