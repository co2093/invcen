<?php

namespace sig\Http\Middleware;

use Closure;

class equipo_middleware  extends EsPerfil
{
    
    public function getPerfil()
    {
        return 'ADMINISTRADOR EQUIPO';
    }
}


