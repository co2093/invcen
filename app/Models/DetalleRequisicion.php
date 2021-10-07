<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRequisicion extends Model
{
     protected $table = 'detalle_requisicions';
    protected $primaryKey = 'id';
 

    protected $fillable=[
    	'id' ,'cantidad_solicitada','cantidad_entregada','precio','requisicion_id','articulo_id'
    ];

    public function articulo(){
    	return $this->hasOne('sig\Models\Articulo','codigo_articulo','articulo_id');		
	}
	 public function requisicion(){
    	return $this->belongsTo('sig\Models\Requisicion','requisicion_id','id');		
	}

    public function descargo(){
        return $this->hasOne('sig\Models\Descargo','id_detalle','id');
    }

    public function getMonto(){
        $monto = $this->cantidad_entregada * round($this->precio,2);
        return $monto;
    }

     
}


