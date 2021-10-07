<?php

namespace sig;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{  
    protected $fillable = [
        'name', 'email', 'usuario','password','activo','perfil_id','departamento_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfil(){
    	return $this->hasOne('sig\Models\Role','id','perfil_id');		
	}
	public function departamento(){
    	return $this->hasOne('sig\Models\Department','id','departamento_id');		
	}

}
