<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
 

    protected $fillable=[
    	'id' ,'name','descripcion','encargado','enviar'
    ];

      //relacion con los usuarios
   public function usuarios(){
		return $this->hasOne('sig\User','departamento_id');
	}

    public function requisiciones(){
        return $this->hasMany('sig\Models\Requisicion','departamento_id');
    }
}
