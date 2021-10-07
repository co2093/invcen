<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
    protected $table = 'art_pres';
	protected $primaryKey = 'id_art_pres';
	
    protected $fillable = [
	    'existencia','precio_unitario','codigo_articulo','id_pres'
	];
	
	//Relacion muchos a uno con articulo
	public function articulo(){
        return $this->belongsTo('sig\Models\Articulo','codigo_articulo','codigo_articulo');
    }
	//Relacion muchos a uno con presentacion
	public function presentacion(){
        return $this->belongsTo('sig\Models\Presentacion','id_pres','id_pres');
    }
	
	//Relacion uno a muchos con articulo
	public function ingresos(){
		return $this->hasMany('sig\Models\Ingreso','id_pres');
	}
	
	public function ingresarExistencia($cantidad,$precio){
	  
		$nuevaExistencia = $cantidad + $this->existencia;
		$nuevoPrecio = (($this->precio_unitario * $this->existencia) +($cantidad * $precio))/$nuevaExistencia;
		$this->existencia = $nuevaExistencia;
		$this->precio_unitario = $nuevoPrecio;
		
  }
  
  public function monto(){
	  return ($this->existencia * $this->precio_unitario);
  }
	
	
}
