<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipo';
    protected $primaryKey = 'id_equipo'; 

    public function tipo(){
    	return $this->hasOne('sig\Models\TipoEquipo','id_tipo_equipo','id_tipo_equipo');
    }

    public function status(){
    	return $this->hasOne('sig\Models\Estados','idestado','idestado');
    }  

    public function bitacora(){
    	return $this->hasMany('sig\Models\BitacoraEquipo','id_equipo','id_equipo');
    }    
}
