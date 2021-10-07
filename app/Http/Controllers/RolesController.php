<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Http\Requests;
use sig\Models\Role;
use Laracasts\Flash\Flash;

class RolesController extends Controller
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
        $roles = Role::all();
        return view('Roles\index')->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Roles.registrar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request,[             
             'nombre'=>'required|unique:roles,name|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ ',
             'descripcion'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ ',
        ]);         


       Role::create([           
            'name'=>$request->input('nombre'),
            'description'=>$request->input('descripcion'),
        ]);
    
        Flash::success('Guardado correctamente.');    
        $roles = Role::all();
        return view('Roles\index')->with('roles',$roles);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol= Role::FindOrFail($id);        
        return view('Roles.eliminar')->with('rol',$rol);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Role::FindOrFail($id);
        return view('Roles.actualizar')->with('rol',$rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[             
             'nombre'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ |unique:roles,name,'.$id.',id',
             'descripcion'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ ',
        ]);
        $r = Role::FindOrFail($id);       
        $r->update([           
            'name'=>$request->input('nombre'),
            'description'=>$request->input('descripcion'),
        ]);
        Flash::success('Se ha Actualizado correctamente.');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $r=Role::FindOrFail($id);
       if($r->id<5){
            flash('Error: no puede eliminarse el PERFIL ','danger');
            return redirect()->back();
       }
       if($r->usuarios->count()>0)
       {
            flash('Error: no puede eliminarse el PERFIL porque hay usuarios asociados','danger');
            return redirect()->back();
        }
        else
        {
            $r->delete();
            flash('eliminado exitosamente','success');
            return redirect()->route('roles.index');
        }
       
    }
}
