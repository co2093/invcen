<?php

namespace sig\Http\Controllers\Article;

use Illuminate\Http\Request;

use sig\Http\Requests;
use sig\Http\Controllers\Controller;
use sig\Models\Article\Provider;
use DB;
use Session;
//use sig\Http\Requests\Provider\ProviderCreateRequest;
//use sig\Http\Requests\Provider\ProviderUpdateRequest;
use Laracasts\Flash\Flash;
use Exception;

class ProviderController extends Controller
{
    public function __construct()
    {
        try {
            $this->middleware('auth');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function index()
    {
        try {
            $providers = Provider::all();
            return view('Provider.index')->with('proveedores', $providers);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function create()
    {
        try{
            return view('Provider.insertar');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre'=>'required|unique:providers|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/|max:60 ',
            'direccion'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ ',
            'vendedor'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s]*$/|max:60',
            'telefono'=>'required|max:9',
            'fax'=>'max:15',
        ]);

        try{
            $proveedor = new Provider();
            $proveedor->nombre = $request->input('nombre');
            $proveedor->direccion = $request->input('direccion');
            $proveedor->telefono = $request->input('telefono');
            $proveedor->email = $request->input('email');
            $proveedor->fax = $request->input('fax');
            $proveedor->vendedor = $request->input('vendedor');
            $proveedor->save();
            Flash::success('Guardado correctamente!!!');
            return redirect()->route('proveedor.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function show($id)
    {
        try{
            $provider= Provider::FindOrFail($id);
            return view('Provider.eliminar')->with('provider',$provider);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $provider = Provider::FindOrFail($id);
            return view('Provider.actualizar')->with('provider', $provider);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nombre'=>'max:60|required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\.]*$/ |unique:providers,nombre,'.$id.',id',
            'direccion'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\.\s\-]*$/ ',
            'vendedor'=>'required|regex: /^[a-zA-Z0-9áéíóúñÑ,\s]*$/|max:60',
            'telefono'=>'required|max:9',
            'fax'=>'max:15',

        ]);
        try {
            $proveedor = Provider::FindOrFail($id);
            $proveedor->nombre = $request->input('nombre');
            $proveedor->direccion = $request->input('direccion');
            $proveedor->telefono = $request->input('telefono');
            $proveedor->email = $request->input('email');
            $proveedor->fax = $request->input('fax');
            $proveedor->vendedor = $request->input('vendedor');
            $proveedor->update();
            Flash::success('Se ha Actualizado correctamente!');
            return redirect()->route('proveedor.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function destroy($id)
    {
        try{
            $p=Provider::FindOrFail($id);
            if($p->ingresos->count() > 0){
                flash('Error: el proveedor es usado por transacciones de ingreso o entrada','danger');
                return redirect()->back();
            }else{
                $p->delete();
                Flash::success('El proveedor fue eliminado');
                return redirect()->route('proveedor.index');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function detail($id)
    {
        try{
            $provider= Provider::FindOrFail($id);
            return response()->json($provider);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
    public function productosList($id){
        try{
            $provider= Provider::FindOrFail($id);
            return view('Provider.productoslist',['proveedor'=>$provider]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
}
