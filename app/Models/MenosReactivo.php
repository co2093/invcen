<?php

namespace sig\Models;

use Illuminate\Database\Eloquent\Model;

class MenosReactivo extends Model
{
    protected $table = 'menos_reactivo';
    protected $primaryKey = 'id_menos_reactivo'; 
    public $timestamps= false;
}
