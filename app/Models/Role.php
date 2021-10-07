<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
       'id','name', 'description', 
    ];

     //relacion con los usuarios
   public function usuarios(){
		return $this->hasMany('sig\User','perfil_id');
	}
}
