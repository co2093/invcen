<?php

namespace sig\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';
    protected $primarykey = 'id';

    protected $fillable=[
    	'id' ,'nombre','direccion', 'telefono', 'fax','correo', 'vendedor' 
    ];
	
	//Relacion muchos a uno con ingreso
	public function ingresos(){
		return $this->hasMany('sig\Models\Ingreso','id_proveedor','id');
	}

   
}
