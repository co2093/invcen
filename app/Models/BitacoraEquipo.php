<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class BitacoraEquipo extends Model
{
    protected $table = 'bitacora_equipo';
    protected $primaryKey = 'id_bitacora';

    public function estadob(){
    	return $this->hasOne('sig\Models\Estados','idestado','idestado');
    }
}
