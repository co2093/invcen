<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Models\ControlArticulo;
use Auth;
use sig\Models\DetalleEntrega;
use sig\Models\Entrega;
use Illuminate\Support\Facades\DB;

use sig\Http\Requests;

//use DB;

class EntregaController extends Controller
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
            $entregas = Entrega::where('iddepartamento','=',Auth::User()->departamento['id'])->get();
            return view('entrega.index', ['entregas' => $entregas]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function create()
    {
        try {
            $controlesArticulo = ControlArticulo::where('iddepartamento', '=', Auth::User()->departamento['id'])->get();
            return view('entrega.create', ['controlesarticulo' => $controlesArticulo]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }

    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'solicitante' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/',

        ]);

        try {
            if (count($request->productos) == 0) {
                flash('No ha seleccionado ningun producto', 'danger');
                return redirect()->back();
            }
            $cont = 0; //Cuenta el numero de cantidades menor o igual cero
            foreach ($request->productos as $producto) {
                $cantidad = $request->input($producto);
                if ((int)$cantidad <= 0) {
                    $cont = $cont + 1;
                }
            }

            if ($cont > 0) {
                flash('Las cantidades deben de ser mayor a cero', 'danger');
                return redirect()->back();
            }
             //Revisa si las cantidades solicitadas son mayores a las existencias
                foreach ($request->productos as $producto) {
                    $cantidad = $request->input($producto);
                    $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();

                    if ($cantidad > $controlArticulo->existencia) {
                        flash('Revise las existencias y la cantidad a entregar', 'danger');
                        return redirect()->back();
                    }

                }


            DB::beginTransaction();
            $entrega = new Entrega();
            $entrega->solicitante = $request->input('solicitante');
            $entrega->descripcion = $request->input('descripcion');
            $entrega->iddepartamento = Auth::User()->departamento['id'];
            $entrega->saveOrFail();

            foreach ($request->productos as $producto) {
                $cantidad = $request->input($producto);
                $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();

                $detalleEntrega = new DetalleEntrega();
                $detalleEntrega->identrega = $entrega->identrega;
                $detalleEntrega->codigo_articulo = $producto;
                $detalleEntrega->iddepartamento = $controlArticulo->iddepartamento;
                $detalleEntrega->cantidadentregada = $request->input($producto);
                $detalleEntrega->saveOrFail();

                $controlArticulo->existencia = $controlArticulo->existencia - $request->input($producto);
                //Actualizamos controlArticulo

                DB::update('update controlarticulo set existencia = ? where codigo_articulo = ? and iddepartamento = ?', [$controlArticulo->existencia, $controlArticulo->codigo_articulo, $controlArticulo->iddepartamento]);

            }

            DB::commit();//Fin de la transaccion
            flash('Entrega realizada exitosamente', 'success');
            return redirect()->route('producto.controlexistencia');

        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function show($id)
    {
        try{
            $entrega = DB::select('select solicitante,fechaentrega,descripcion from entrega where iddepartamento = ? and identrega = ?',[Auth::User()->departamento['id'],$id]);

        $entregas = DB::select('select cantidadentregada,fechaentrega,solicitante,descripcion,nombre_articulo,nombre_unidadmedida from  detalleEntregaView where iddepartamento = ? and identrega = ?',[Auth::User()->departamento['id'],$id]);

        return view('entrega.details',['entregas'=>$entregas,'entrega'=>$entrega]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function edit($id)
    {
        try {
            $todoscontrolesArticulo = ControlArticulo::where('iddepartamento', '=', Auth::User()->departamento['id'])->get();
            $entrega = Entrega::where('identrega','=',$id)->where('iddepartamento','=',Auth::User()->departamento['id'])->first();

            //dd($entrega->detallesEntrega);

            $controlesArticulo = array();
            $codigos= array();

            foreach ($todoscontrolesArticulo as $ca){
                $nuevoca = ['codigo_articulo'=>$ca->codigo_articulo,'nombre_articulo'=>$ca->articulo->nombre_articulo,'nombre_unidadmedida'=>$ca->articulo->unidad->nombre_unidadmedida,'existencia'=>$ca->existencia,'checked'=>false,'cantidadentregada'=>0];
                $controlesArticulo[] = $nuevoca;
                $codigos[]= $ca->codigo_Articulo;
            }

            foreach ($entrega->detallesEntrega as $de){

                for ($i= 0; $i < count($controlesArticulo); $i++){
                    if ($de->codigo_articulo == $controlesArticulo[$i]['codigo_articulo']) {
                        $controlesArticulo[$i]['existencia'] = $controlesArticulo[$i]['existencia'] + $de->cantidadentregada;
                        $controlesArticulo[$i]['checked'] = true;
                        $controlesArticulo[$i]['cantidadentregada'] = $de->cantidadentregada;
                    }
                }
            }

            return view('entrega.edit', ['controlesarticulo' => $controlesArticulo, 'entrega'=>$entrega]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'solicitante' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/',

        ]);


        try {
            $entrega = Entrega::where('identrega','=',$id)->where('iddepartamento','=',Auth::User()->departamento['id'])->first();
            if(!$entrega){
                flash('Error: Entrega no existe','danger');
                return redirect()->route('producto.entrega.index');
            }

            //$productosAnteriores = $entrega->detallesEntrega;
            //$nuevosProductos[] = $request->productos;
            if (count($request->productos) == 0) {
                flash('No ha seleccionado ningun producto', 'danger');
                return redirect()->back();
            }

            $cont = 0;
            foreach ($request->productos as $producto) {
                $cantidad = $request->input($producto);

                if ((int)$cantidad <= 0) {
                    $cont = $cont + 1;
                }
            }

            if ($cont > 0) {
                flash('Las cantidades de los productos seleccionados deben de ser mayor a cero', 'danger');
                return back();
            }


            $productosAnteriores = array();
            $productosNuevos = $request->productos;


            //arreglo de productos anteriores
            foreach ($entrega->detallesEntrega as $de){
                $productosAnteriores[] = $de->codigo_articulo;
            }


            //Productos que seran eliminados
            $productosEliminar = array();
            $productosEliminar = array_diff($productosAnteriores,$productosNuevos);

            //Productos que seran actualizados

            $productosActualizar = array();
            $productosActualizar = array_intersect($productosAnteriores,$productosNuevos);

            //Productos que no existian y que hay que guardar

            $productosGuardar  = array();
            $productosGuardar = array_diff($productosNuevos,$productosAnteriores);

            //Verificacion de existencias de los productos a guardar
            foreach ($productosGuardar as $producto) {
                    $cantidad = $request->input($producto);
                    $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();
                    //dd($controlArticulo);
                    if ($cantidad > $controlArticulo->existencia) {
                        flash('Revise las existencias y la cantidad a entregar', 'danger');
                        return back();
                    }
            }

           //Verificacion de existencias de los productos a actualizar
            foreach ($productosActualizar as $producto) {
                foreach ($entrega->detallesEntrega as $productoA) {
                    if ($producto == $productoA->codigo_articulo) {
                        if ((int)$request->input($producto) != $productoA->cantidadentregada) {
                            if ((int)$request->input($producto) > $productoA->cantidad_entregada) {
                                $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();

                                $quitar = (int)$request->input($producto) - $productoA->cantidadentregada;
                                if($controlArticulo->existencia < $quitar){
                                    flash('Revise las existencias existentes','danger');
                                    return back();
                                }

                            }
                        }
                    }
                }
            }

            $entrega->solicitante = $request->input('solicitante');
            $entrega->descripcion = $request->input('descripcion');


            DB::beginTransaction();

            //Productos a eliminar de la entrega
            foreach ($productosEliminar as $producto){
                $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();
                foreach ($entrega->detallesEntrega as $de){
                    if($de->codigo_articulo == $producto){
                        $existencia = $controlArticulo->existencia + $de->cantidadentregada;
                        DB::update('update controlarticulo set existencia = ? where codigo_articulo = ? and iddepartamento = ?', [$existencia, $controlArticulo->codigo_articulo, $controlArticulo->iddepartamento]);
                        $de->delete();                    }
                }
            }

            //Productos a actualizar
            foreach ($productosActualizar as $producto) {
                foreach ($entrega->detallesEntrega as $productoA) {
                    if ($producto == $productoA->codigo_articulo) {



                        if ((int)$request->input($producto) != $productoA->cantidadentregada) {
                                $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();


                                if ((int)$request->input($producto) > $productoA->cantidad_entregada) {
                                    $quitar = (int)$request->input($producto) - $productoA->cantidadentregada;

                                    $controlArticulo->existencia = $controlArticulo->existencia - $quitar;

                                    $productoA->cantidadentregada = (int)$request->input($producto);

                                    $productoA->update();
                                    DB::update('update controlarticulo set existencia = ? where codigo_articulo = ? and iddepartamento = ?', [$controlArticulo->existencia, $controlArticulo->codigo_articulo, $controlArticulo->iddepartamento]);
                                } else {
                                    $devolver = $productoA->cantidadentregada - (int)$request->input($producto);
                                    $controlArticulo->existencia = $controlArticulo->existencia + $devolver;

                                    $productoA->cantidadentregada = (int)$request->input($producto);
                                    $productoA->update();
                                    DB::update('update controlarticulo set existencia = ? where codigo_articulo = ? and iddepartamento = ?', [$controlArticulo->existencia, $controlArticulo->codigo_articulo, $controlArticulo->iddepartamento]);
                                }

                        }
                    }
                }
            }

            //Productos a guardar
            foreach ($productosGuardar as $producto) {

                        $cantidad = $request->input($producto);
                        $controlArticulo = ControlArticulo::where('codigo_articulo', '=', $producto)->where('iddepartamento', '=', Auth::User()->departamento['id'])->first();

                        $detalleEntrega = new DetalleEntrega();
                        $detalleEntrega->identrega = $entrega->identrega;
                        $detalleEntrega->codigo_articulo = $producto;
                        $detalleEntrega->iddepartamento = $controlArticulo->iddepartamento;
                        $detalleEntrega->cantidadentregada = $request->input($producto);
                        $detalleEntrega->saveOrFail();
                        $controlArticulo->existencia = $controlArticulo->existencia - $request->input($producto);

                        //Actualizamos controlArticulo

                        DB::update('update controlarticulo set existencia = ? where codigo_articulo = ? and iddepartamento = ?', [$controlArticulo->existencia, $controlArticulo->codigo_articulo, $controlArticulo->iddepartamento]);

            }
            $entrega->update();

            DB::commit();//Fin de la transaccion
            flash('Entrega actualizada exitosamente', 'success');
            return redirect()->route('producto.entrega.index');

        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function destroy($id)
    {
        //
    }
}
