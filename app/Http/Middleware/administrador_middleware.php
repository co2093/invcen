<?php

namespace sig\Http\Middleware;

class administrador_middleware extends EsPerfil
{
    public function getPerfil()
    {
        return 'ADMINISTRADOR SISTEMA';
    }
}
