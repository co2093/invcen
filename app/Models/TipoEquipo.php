<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    protected $table = 'tipo_equipo';
    protected $primaryKey = 'id_tipo_equipo';    
    public $timestamps = false;
}
