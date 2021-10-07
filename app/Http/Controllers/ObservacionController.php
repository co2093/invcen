<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;
use sig\Models\Observacion;

class ObservacionController extends Controller
{
	 public function __construct()
    {
        try {
            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }
    
    public function index(){
		$observaciones = Observaciones::orderBy('create_at','asc')->get();		
		return view('observaciones.index',['observaciones'=>$observaciones]);
	}
	
	public function create()
    {
        return view('observaciones.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
		    'observacion' => 'required',			
		]);
		
		Observacion::create([
		           'descripcion_observacion' =>$request->input('observacion')
		           ]);
		flash('Observacion creada exitosamente','success');	   
		return redirect()->route('observacion.index');
	     
    }

    public function show($idObservacion)
    {
       $observacion = Observacion::findOrFail($idObservacion);	   
	   return view('observaciones.details',['observacion'=>$observacion]);
	}    
 
    public function edit($idObservacion)
	{
       $observacion = Observacion::findOrFail($idObservacion);
	   return view('observaciones.edit',['observacion'=>$observacion]); 
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
		   'observacion'=>'required'
		]);
		$observacion = Observacion::FindOrFail($id);
		if($observacion){
			$observacion->update([
			  'descripcion_observacion' => $request->input('observacion')
			  ]);
	    flash('Observacion actualizado exitosamente','success');
		return redirect()->route('observacion.index');			
		}else{
			flash('Error: no se pudo actualizar la observacion','danger');
			return redirect()->route('observacion.index');
		}
				    
    }
    
	public function delete($idObservacion){
			$observacion =Observacion::findOrFail($idObservacion);
			return view('observaciones.delete',['observacion'=>$observacion]);
		}
    
    public function destroy($idObservacion)
    {
        $observacion = Observacion::findOrFail($idObservacion);		
		$observacion->delete();
		flash('Observacion eliminada exitosamente','success');
		    return redirect()->route('observacion.index');
    
	
}
}
