<?php

namespace sig\Models;
use sig\Models\Articulo;

//Francisco Vasquez Perez
//Clase contiene metodos estaticos para generar codigos de articulo de forma ordenada
class GenerarCodigo
{
    //Devuelve el valor maximo de todos los codigos articulos registrados
	//que usa el formato AAespecificoNNN, donde las dos primeras son letras
	//provenientes del nombre del articulo y NNN representa el contador para 
	//tener ordenados los articulos de acuerdo a especificos
	private static function maximo($articulos){
		$max = 0;
		$valor = 0;
		if(count($articulos ) == 0){
			$max = 0;
		}else{
		foreach($articulos as $articulo)
		{   //$articulo = (Articulo)$articulo;
		    //Obtiene los ulimos 3 caracteres del codigo de articulo y lo convierte a entero
		    $valor = (int)substr($articulo->codigo_articulo,-3);		    
		    if($max < $valor){
				//Comprueba y actualiza el maximo entre todos los contadores del codigo de articulos
				$max = $valor;
			}
		}
		}
	    //Devuelve el valor maximo entre todos los codigo de articulos registrados
	    return $max;
	}
	
	public static function getCodigo($articulos, $especifico, $nombre){		
		$ini="";//Contendra los dos primeros caracteres del codigo obtenidos del nombre del articulo
		$codigo = "";//Contiene el codigo del articulo generado
		$valMaximo = GenerarCodigo::maximo($articulos);
		$valMaximo = $valMaximo + 1;//Incrementamos en uno el contador de los registros de articulos
		$strmax = (string) $valMaximo;//lo convertimos a cadena
		if(strlen($strmax) == 1){
			$strmax = "00".$strmax;//Concatena 2 ceros a la izquierda
		}
		if(strlen($strmax) == 2){
			$strmax = "0".$strmax;//Concatena un cero a la izquierda
		}
	    $valores=explode(" ",$nombre);//Crea un arreglo con todas las palabras del nombre
		if(count($valores)==1){
			//Comprueba si tiene solo una palabra el nombre toma los dos primeros caracteres
			//y los convierte a mayusculas
			$ini = strtoupper(substr($valores[0],0,2));
		}
		if(count($valores)>1){
			//Si tiene dos o mas toma el primer caracter de las dos primeras palabras
			//y las convierte a mayusculas
			$ini = strtoupper(substr($valores[0],0,1).substr($valores[1],0,1));
		}
		
		//Genera el codigo en el formato AAespecificoNNN
		$codigo = $ini.$especifico.$strmax;
		return $codigo;		
	}
}
