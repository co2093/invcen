<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;
use DB;
use Session;
//importacion del modelo a usar con el ORM
use sig\Models\UnidadMedida;
use Exception;

class UnidadMedidaController extends Controller
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
        try {
            $unidades = UnidadMedida::orderBy('nombre_unidadmedida', 'asc')->get();
            return view('unidadmedida.index', ['unidades' => $unidades]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function create()
    {
        try {
            return view('unidadmedida.create');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_unidadmedida' => 'required|regex: /^[a-zA-Z0-9áéíóúñÑ\/\s]*$/ |unique:unidad_medida,nombre_unidadmedida',
        ]);
        try {
            UnidadMedida::create([
                'nombre_unidadmedida' => $request->input('nombre_unidadmedida')
            ]);
            flash('Unidad de medida guardada exitosamente', 'success');
            return redirect()->route('unidad.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function show($idUnidadMedida)
    {
        try {
            $unidad = UnidadMedida::findOrFail($idUnidadMedida);
            return view('unidadmedida.details', ['unidad' => $unidad]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();

        }
    }

    public function edit($idUnidadMedida)
    {
        try {
            $unidad = UnidadMedida::findOrFail($idUnidadMedida);
            return view('unidadmedida.edit', ['unidad' => $unidad]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        //Valida que el nombre de la unidad de medida sea unica, exceptuando ella misma
        $this->validate($request,[
            'nombre_unidadmedida'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ\/\s]*$/ |unique:unidad_medida,nombre_unidadmedida,'.$id.',id_unidad_medida'
        ]);
        try {
            $unidad = UnidadMedida::FindOrFail($id);
            if ($unidad) {
                $unidad->update([
                    'nombre_unidadmedida' => $request->input('nombre_unidadmedida')
                ]);
                flash('Unidad de medida actualizado exitosamente', 'success');
                return redirect()->route('unidad.index');
            } else {
                flash('Error: no se pudo actualizar la unidad de medida', 'danger');
                return redirect()->route('unidad.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function delete($idUnidadMedida){
        try {
            $unidad = UnidadMedida::findOrFail($idUnidadMedida);
            return view('unidadmedida.delete', ['unidad' => $unidad]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function destroy($idUnidadMedida)
    {
        try {
            $unidad = UnidadMedida::findOrFail($idUnidadMedida);
            //Comprueba que la unidad a eliminar no esta relacionado con ningun articulo
            if ($unidad->articulo->count() > 0) {
                flash('Error: No puede eliminarse la unidad de medida porque esta siendo usada por productos', 'danger');
                return redirect()->back();
            } else {
                $unidad->delete();
                flash('Unidad de medida eliminada exitosamente', 'success');
                return redirect()->route('unidad.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }
}

