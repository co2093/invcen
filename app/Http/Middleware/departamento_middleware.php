<?php

namespace sig\Http\Middleware;

class departamento_middleware extends EsPerfil{
	public function getPerfil(){
		return 'DEPARTAMENTO';
	}
}