<?php

namespace sig\Http\Middleware;

class financiero_middleware extends EsPerfil{
	public function getPerfil(){
		return 'ADMINISTRADOR FINANCIERO';
	}
}