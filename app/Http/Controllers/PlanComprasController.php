<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Http\Requests;
use DB;
use sig\Models\Articulo;
use Auth;

class PlanComprasController extends Controller
{


    public function index(){
            
        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '=', "Pendiente")
        ->get();
        
        return view('plandecompras.index', compact('planDelUsuario'));
        
    }


    public function consultarProductos(){
        $articulos = Articulo::all();

        return view('plandecompras.consultarproducto', compact('articulos'));
    }    


    public function add(Request $request)
    {
            $articulo = Articulo::findOrFail($request->input('codigo'));
            $articulo->cantidad = $request->input('cantidad');
            $req = \Session::get('articulos');
            $req[$articulo->codigo_articulo] = $articulo;
            \Session::put('articulos', $req);
            return redirect()->route('plan.index');
    }



    public function delete($cod)
    {
        try {
            $req = \Session::get('articulos');
            unset($req[$cod]);
            \Session::put('articulos', $req);
            return redirect()->route('plan.index');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function trash()
    {
        try {
            \Session::forget('articulos');
            flash('Plan vaciado exitosamente', 'success');
            return redirect('plandecompras.index');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function vaciar()
    {
        try {
            return view('plandecompras.index');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function agregarNuevo(){

        return view('plandecompras.agregarproducto');

    }

    public function store(Request $request){

        DB::table('plan_compras')->insert([
            'cantidad' => $request->input('cantidad'),
            'nombre_producto' => $request->input('nombre_producto'),
            'especificaciones' => $request->input('especificaciones'),
            'precio_unitario' => $request->input('precio'),
            'proveedor' => $request->input('proveedor'),
            'cotizacion' => $request->input('cotizacion'),
            'user_id' => $request->input('user_id'),
            'estado' => 'Pendiente' 
        ]);

        flash('Producto agregado al plan de compras exitosamente', 'success');
        return redirect()->back();

    }

    public function deleteProduct($idProduct){

        DB::table('plan_compras')
        ->where('id', '=', $idProduct)
        ->delete();

        flash('Producto eliminado del plan de compras exitosamente', 'danger');
        return redirect()->back();
    }

    public function editProduct($idProduct){

        $product = DB::table('plan_compras')
        ->where('id', '=', $idProduct)
        ->first();

        return view('plandecompras.edit', compact('product'));

    }


    public function updateProduct(Request $request){

        DB::table('plan_compras')
        ->where('id', $request->input('idProduct'))
        ->update([
            'cantidad'=>$request->input('cantidad'),
            'nombre_producto'=>$request->input('nombre_producto'),
            'especificaciones'=>$request->input('especificaciones'),
            'precio_unitario'=>$request->input('precio'),
            'proveedor'=>$request->input('proveedor'),
            'cotizacion'=>$request->input('cotizacion')
        ]);

        flash('Producto editado exitosamente', 'info');
        return redirect()->route('plan.index');
    }





}
