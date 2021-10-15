<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $table = 'observacion';
	protected $primaryKey = 'id_observacion';
	
	protected $fillable = ['descripcion_observacion'];
	
}
