<?php

namespace sig\Http\Controllers\Departamento;

use Illuminate\Http\Request;

use sig\Http\Requests;
use sig\Http\Controllers\Controller;
use sig\Models\Department;
use sig\User;
use DB;
use Session;
use Exception;
use Auth;

use Laracasts\Flash\Flash;

class DepartmentController extends Controller
{
    public function __construct()
    {
        try {
            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function index()
    {
        try{
            $departamento = Department::orderBy('name', 'asc')->get();
            return view('Department.index', ['departamento' => $departamento]);

        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function asignarUsuario()
    {
        try{
            $departamento = Department::where('encargado','=','No Definido')->orderBy('name','asc')->get();
            return view('Department.asignarUsuario',['departamento'=>$departamento]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('Department.insertar');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'max:100|required|regex: /^[a-zA-Z0-9áéíóúñÑ.\s]*$/ |unique:departments,name',
            'descripcion'=>'required',
        ]);
        try{
            Department::create([
                'name' =>$request->input('name'),
                'descripcion' =>$request->input('descripcion'),
                'encargado'=>'No Definido',
                'enviar'=>'true',
            ]);
            flash('Información guardada exitosamente','success');
            return redirect()->route('departamento.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $department = Department::FindOrFail($id);
            return view('Department.eliminar', ['department' => $department]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function edit($id)
    {
        try{
            $department = Department::findOrFail($id);
            return view('Department.actualizar',['department'=>$department]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name'=>'max:100|required|regex: /^[a-zA-Z0-9áéíóúñÑ.\s]*$/ |unique:departments,name,'.$id.',id',
            'descripcion'=>'required',

        ]);
        try{
            $departament = Department::FindOrFail($id);
            if($departament){
                $departament->update([
                    'name' => $request->input('name'),
                    'descripcion' => $request->input('descripcion'),

                ]);
                flash('Actualizado exitosamente','success');
                return redirect()->route('departamento.index');
            }else{
                flash('Error: no se pudo actualizar el Usuario/Unidad','danger');
                return redirect()->route('departamento.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function destroy($id)
    {
        try{
            $departamento = Department::findOrFail($id);

            if($departamento->requisiciones->count()>0)
            {
                flash('Error: no puede eliminarse el Usuario/Unidad porque hay Solicitudes asociadas','danger');
                return redirect()->back();
            }elseif ($departamento->usuarios && $departamento->requisiciones->count() == 0){

                flash('Eliminado exitosamente','success');
                $departamento->usuarios->delete();
                $departamento->delete();
                return redirect()->route('departamento.index');
            }
            else
            {
                $departamento->delete();
                flash('Eliminado exitosamente','success');
                return redirect()->route('departamento.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

}