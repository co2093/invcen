<?php

namespace sig\Http\Controllers;
use Illuminate\Http\Request;

use sig\Http\Requests;
use sig\Models\Especifico;
use DB;
use Session;
use Exception;


class EspecificoController extends Controller
{   
	public function __construct()
    {
        try {
            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }
    //lista los especificos
	public function index(){
	    try {
            $especificos = Especifico::orderBy('id', 'asc')->get();
            return view('especifico.index', ['especificos' => $especificos]);
        }catch (Exception $ex){
	        return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
	}
	
	public function create()
    {
        try{
        return view('especifico.create');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
		    'numero' => 'required |integer|min:1|digits:5 |unique:especificos,id',
			//'titulo' => 'required|regex: /^[a-zA-Z0-9áéíóúñÑ\s]*$/ |unique:especificos,titulo_especifico',
           // 'descripcion' => 'regex: /^[a-zA-Z0-9$:,;_áéíóúñÑ\s]*$/',

        ]);
		    try{
				Especifico::create([
		           'id' =>$request->input('numero'),
		           'titulo_especifico' =>$request->input('titulo'),
		           'descripcion_epecifico' =>$request->input('descripcion')
		        ]);
				flash('Especifico guardado exitosamente','success');
		        return redirect()->route('especifico.index');
            }catch (Exception $ex){
                return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
            }
	     
    }

    public function show($id)
    {
        try{
            $especifico = Especifico::findOrFail($id);
            return view('especifico.details',['especifico'=>$especifico]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function edit($id)
    {
        try{
            $especifico = Especifico::findOrFail($id);
            return view('especifico.edit',['especifico'=>$especifico]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
		   //'titulo'=>'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s]*$/ | unique:especificos,titulo_especifico,'.$id.',id',
           // 'descripcion' => 'regex: /^[a-zA-Z0-9$:,;_áéíóúñÑ\s]*$/'
		]);
        try{
		$especifico = Especifico::FindOrFail($id);
		if($especifico){
			$especifico ->update([
			  'titulo_especifico' => $request->input('titulo'), 
			  'descripcion_epecifico' =>$request->input('descripcion')
			]);
		    flash('Especifico actualizado exitosamente','success');
		    return redirect()->route('especifico.index');
			
		}else{
			flash('Error:No se encontro ningun especifico','danger');
			return redirect()->route('especifico.index');
		}
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
    
	public function delete($id){
	    try {
            $especifico = Especifico::findOrFail($id);
            return view('especifico.delete', ['especifico' => $especifico]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
	}
    
    public function destroy($id)
    {
        try {
            $especifico = Especifico::findOrFail($id);
            if ($especifico->articulo->count() > 0) {
                flash('Error: no puede eliminarse el especifico porque hay productos que lo estan usando', 'danger');
                return redirect()->back();
            } else {
                $especifico->delete();
                flash('Especifico eliminado exitosamente', 'success');
                return redirect()->route('especifico.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
}
