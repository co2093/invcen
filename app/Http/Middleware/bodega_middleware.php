<?php

namespace sig\Http\Middleware;

class bodega_middleware extends EsPerfil{
	public function getPerfil(){
		return 'ADMINISTRADOR BODEGA';
	}
}