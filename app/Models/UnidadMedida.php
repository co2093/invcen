<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;
use sig\Models\Articulo;

class UnidadMedida extends Model
{
    protected $table = 'unidad_medida';
	protected $primaryKey = 'id_unidad_medida';
	
	protected $fillable = ['nombre_unidadmedida'];
	
	//Relacion uno a muchos con articulo
	public function articulo(){
		return $this->hasMany('sig\Models\Articulo','id_unidad_medida');
	}
}
