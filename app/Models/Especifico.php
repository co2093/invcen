<?php

namespace sig\Models;
use sig\Models\Articulo;

use Illuminate\Database\Eloquent\Model;

class Especifico extends Model
{
    protected $table = 'especificos';
	protected $primarykey = 'id';
	//Indica que no se esta usando una llave autoincremental
    protected $fillable = [
	    'id','titulo_especifico','descripcion_epecifico',
	];
	
	public function getEspecificoTitulo(){
		$espTitulo = $this->id." | ".$this->titulo_especifico;
		return $espTitulo;
	}
	//Relacion uno a muchos con articulo
	public function articulo(){
		return $this->hasMany('sig\Models\Articulo','id_especifico');
	}
	
}
