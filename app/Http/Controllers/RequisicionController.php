<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Http\Requests;
use sig\Models\Articulo;
use sig\Models\Requisicion;
use sig\Models\DetalleRequisicion;
use sig\Models\Department;
use Jenssegers\Date\Date;
use sig\Models\CodigoRequisicion;
use Auth;
use DB;
use Exception;
use sig\Models\MenosReactivo;


class RequisicionController extends Controller
{

    public function __construct()
    {
        try {
            if (!\Session::has('articulos'))

                \Session::put('articulos', array());

            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }

    }

    public function listaCompra()
    {
        try {
            $articulos = Articulo::where('existencia', '>', 0)->orderBy('id_especifico', 'asc')->orderBy('created_at', 'asc')->get();
            return view('Requisicion.listaCompra', ['articulos' => $articulos]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function denegarConfirm($id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);

            return view('Requisicion.denegarConfirm', ['requisicion' => $requisicion]);

        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function denegar(Request $request, $id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            $requisicion->estado = 'denegado';
            $requisicion->update();
            flash('Solicitud denegada con exito', 'success');

            /*para eliminar los reactivos agregados*/
            $detalles = DetalleRequisicion::where('requisicion_id',$requisicion->id)->get();
            foreach ($detalles as $detalle) {
                //se eliminan los menosReactivo de ese detalle de requisicion
                MenosReactivo::where('id_detalle_requisicion',$detalle->id)->delete();                
            }

            return redirect()->route('requisicion-listar');

        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }

    }

    public function editarConfirm($id)
    {
        try {
            $requisicion = Requisicion::findOrFail($id);
            return view('requisicion.editarConfirm', ['requisicion' => $requisicion]);

        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }

    }

    public function volverEditar($id)
    {
        try {
            DB::beginTransaction();
            $req = Requisicion::where('id', '=', $id)->first();
            $departamento = Department::where('id', $req->departamento_id)->first();
            $departamento->enviar = true;
            $req->estado = 'editar';
            $departamento->update();
            $req->update();
            DB::commit();//Fin de la transaccion
            flash('peticion realizada correctamente', 'success');
            return redirect()->action('RequisicionController@index');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    //funcion para ver la requisicion que se esta creando
    public function crear()
    {
        /*
       * Esta funcion permite mostrar la pagina principal para la creacion de la requisicion
       */
        try {
            if (\Auth::User()->departamento['enviar'] == 'true') {

                if (!empty(\Session::get('articulos'))) {
                    $articulos = \Session::get('articulos');
                    $total = $this->total();
                    return view('Requisicion.crear', ['articulos' => $articulos, 'total' => $total]);
                } else {
                    return view('Requisicion.crear', ['articulos' => null, 'total' => null]);
                }
            } else {
                flash('No es periodo de envío de Solicitudes', 'danger');
                return back();
            }
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    //Esta funcion agrega un producto a la requisicion enviada desde
    //la funcion index de DetalleController@index junto a la vista agregar.blade.php
    public function add(Request $request)
    {
        try {
            $articulo = Articulo::findOrFail($request->input('codigo'));
            $articulo->cantidad = $request->input('cantidad');
            $req = \Session::get('articulos');
            $req[$articulo->codigo_articulo] = $articulo;
            \Session::put('articulos', $req);
            return redirect()->route('requisicion-show');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    //funcion para eliminar articulos de la lista
    public function delete($cod)
    {
        try {
            $req = \Session::get('articulos');
            unset($req[$cod]);
            \Session::put('articulos', $req);
            return redirect()->route('requisicion-show');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }
    //funcion para vaciar la variable de session requisicion
    //En caso que el administrador del departamento no quiera enviar la requisicion
    public function trash()
    {
        try {
            \Session::forget('articulos');
            flash('Solicitud vaciada exitosamente', 'success');
            return redirect('requisicion/crear');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    //funcion para calcular el total
    private function total()
    {
        try {
            $articulos = \Session::get('articulos');
            $total = 0;
            foreach ($articulos as $a) {
                $total += $a->precio_unitario * $a->cantidad;
            }
            return $total;
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function create()
    {
        //
    }


    public function store()
    {
        try {

            if (\Session::has('articulos') and !empty(\Session::get('articulos'))) {
                //CREACION DE LA REQUISICION
                $date = Date::now();
                $año = $date->format('Y');

                //Se obtiene la fecha de inicio de año y fin de año
                $inicio = new Date($año . '-1-1');
                $fin = new Date($año . '-12-31');

                //Se obtienen las requisiciones creadas durante el año
                $requisiciones = Requisicion::whereBetween('created_at', array($inicio, $fin))->get();

                //Se genera el codigo para la nueva requisicion
                $codigo = CodigoRequisicion::getCodigo($requisiciones, $año);

                //Se crea la requisicion
                $requisicion = new Requisicion();
                $requisicion->id = $codigo;
                $requisicion->estado = 'almacenado';
                $requisicion->departamento_id = \Auth::User()->departamento_id;
                $requisicion->save();

                //SE OBTIENEN LOS ARTICULOS A INCLUIR EN LA REQUISICION
                $articulos = \Session::get('articulos');

                $departamento = Department::where('id', \Auth::User()->departamento_id)->first();

                if ($requisicion->estado == 'almacenado' && $requisicion->id != null) {
                    //guardamos cada registro de articulos que se solicita
                    foreach ($articulos as $a) {
                        DetalleRequisicion::create([
                            'cantidad_solicitada' => $a->cantidad,
                            'precio' => $a->precio_unitario,
                            'requisicion_id' => $requisicion->id,
                            'articulo_id' => $a->codigo_articulo,
                        ]);
                    }
                    //actualiza la requisicion una vez se envia
                    $requisicion->update([
                        'estado' => 'enviada',
                        'fecha_solicitud' => Date::now(),
                    ]);
                    //deshabilitamos que el departemento envie requisiciones
                    $departamento->update([
                        'enviar' => 'false',
                    ]);
                    //eliminamos la variable de sesion
                    \Session::forget('articulos');
                    flash('Solicitud enviada exitosamente', 'success');
                } else {
                    flash('Problema al enviar la solicitud,consulte con el administrador', 'danger');
                }

                return redirect()->action('HomeController@index');

            } else {
                flash('No ha ingresado ningun producto', 'danger');
                return back();
            }
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }


    } // fin de almacenar(store) la requisicion y sus detalles


    public function show($id)
    {
        //
    }


    /*public function edit($id)
    {

    }
*/

    public function update($cod, $cantidad)
    {
        /*$articulos = \Session::get('articulos');
        $articulos[$cod]->cantidad=$cantidad;
        \Session::put('articulos',$articulos);

        return redirect()->route('requisicion-show');*/
    }

    public function destroy($id)
    {
        /*
        $req = Requisicion::FindOrFail($id);
        $detalles = DetalleRequisicion::where('requisicion_id',$req->id)->get();
        foreach ($detalles as $d) {
            $articulo = Articulo::where('codigo_articulo',$d->articulo_id)->first();
            $suma = ($articulo->precio_unitario * $articulo->existencia)+($d->cantidad_entregada*$d->precio);
            $precio = $suma/($articulo->existencia + $d->cantidad_entregada);

            $articulo->update([
                'existencia'=>$articulo->existencia + $d->cantidad_entregada,
                'precio_unitario'=>$precio,
            ]);
        }
        $req->update([
            'estado' => 'almacenada',
        ]);
        */
        flash('Esta en estado de evaluacion', 'success');
        return redirect()->route('requisicion-listar');
    }

    //mostrar todas las requisiciones
    public function index()
    {
        try {
            if (Auth::User()->perfil['name'] == 'DEPARTAMENTO') {
                $requisicion = Requisicion::where([['estado', '!=', 'almacenado'], ['departamento_id', '=', Auth::User()->departamento_id]])->orderBy('fecha_solicitud', 'desc')->get();

                return view('Requisicion.departamento_lista', ['requisicion' => $requisicion]);
            } else {
                if (Auth::User()->perfil['name'] == 'ADMINISTRADOR FINANCIERO') {
                    $requisiciones = Requisicion::where('estado', '=', 'actualizada')->orderBy('fecha_solicitud', 'desc')->get();
                } else {
                    $requisiciones = Requisicion::where('estado', '!=', 'almacenado')->orderBy('fecha_solicitud', 'desc')->get();
                }
                return view('Requisicion.index', ['requisicion' => $requisiciones]);
            }
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }

    }

    public function financieroRequisiciones()
    {
        try {
            if (Auth::User()->perfil['name'] == 'ADMINISTRADOR FINANCIERO') {
                $requisiciones = Requisicion::where('estado', '=', 'aprobada')->orWhere('estado', '=', 'denegado')->orWhere('estado', '=', 'editar')->orderBy('fecha_solicitud', 'desc')->get();
            }
            return view('Requisicion.financieroRequisiciones', ['requisicion' => $requisiciones]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    /*
     * Muestra la pagina prncipal para habilitar o deshabilitar a que un departamento pueda
     * hacer realizar requisiciones
     */
    public function HabilitarEnvio()
    {
        try {
            $departamentos = Department::orderBy('name', 'asc')->get();
            return view('Requisicion.habilitar_envio_panel', ['departamentos' => $departamentos]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function gestionarEnvios($id)
    {
        try {
            if ($id == -7) {
                //Habilita a los departamentos a que puedan realizar requisiciones
                $departamentos = Department::all();
                foreach ($departamentos as $d) {
                    $d->update([
                        'enviar' => 'true',
                    ]);
                }
            } else {
                //Deshabilita a los departamentos a que puedan realizar requisiciones
                if ($id == -9) {
                    $departamentos = Department::all();
                    foreach ($departamentos as $d) {
                        $d->update([
                            'enviar' => 'false',
                        ]);
                    }
                } else {
                    //Habilita y deshabilita a un departamento a que pueda realizar una requisicion

                    $departamento = Department::where('id', $id)->first();
                    if ($departamento->enviar == 'true') {
                        $departamento->update([
                            'enviar' => 'false',
                        ]);
                    } else {
                        $departamento->update([
                            'enviar' => 'true',
                        ]);
                    }

                }
            }
            return back();
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function desechar($id)
    {
        try {
            $req = Requisicion::FindOrFail($id);
            return view('Requisicion.advertencia', ['requisicion' => $req]);
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function confirmarEnvio()
    {
        try {
            return view('Requisicion.enviarConfirm');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function vaciarConfirm()
    {
        try {
            return view('Requisicion.vaciar');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    public function habilitarPeriodo()
    {
        $periodo = DB::table('periodo')->first();

        //dd($periodo);

        if ($periodo->estado == 1) {
            // code...
            $estado = "Habilitado";
        }else{
            $estado = "Deshabilitado";
        }


        return view('Requisicion.habilitar', compact('estado'));
    }

    public function editarEstado(Request $request)
    {   

        //dd($request->input('periodoEstado'));

        if ($request->input('periodoEstado') == "1") {
            // code...
            $nuevoEstado = 1;
        }else{
            $nuevoEstado = 0;
        }

        //dd($nuevoEstado);

        DB::table('periodo')->where('periodo_id',1)->update(['estado' => $nuevoEstado]);

        flash('Periodo de solicitudes actualizado exitosamente', 'success');
        return redirect()->route('habilitarPeriodo');

        
    }

}
