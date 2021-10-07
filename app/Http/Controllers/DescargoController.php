<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;
use sig\Models\Articulo;
use sig\Models\Descargo;
use Jenssegers\Date\Date;
use sig\Models\Transaccion;
use sig\Models\Requisicion;
use sig\Models\DetalleRequisicion;
use Laracasts\Flash\Flash;
use Auth;
use sig\User;
use PDF;
use Exception;


class DescargoController extends Controller
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
        try {
            $descargos = Descargo::orderBy('id_descargo', 'asc')->get();
            return view('descargos.index', ['descargos' => $descargos]);
        }catch (Exception $ex){
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function aprobar($id)
    {
        try{
            $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
            $requisicion = Requisicion::where('id','=',$id)->first();
            foreach ($detalle as $de) {
                if($de->cantidad_entregada == 0){
                    $de->delete();
                }
            }

            if(Auth::User()->perfil['name'] == 'ADMINISTRADOR BODEGA')
            {
                $requisicion->update([
                    'estado' => 'actualizada',
                    'bodega_id'  =>  Auth::User()->id,
                ]);
            }
            elseif(Auth::User()->perfil['name'] == 'ADMINISTRADOR FINANCIERO'){
                    foreach ($detalle as $d) {
                        $a = Articulo::where('codigo_articulo', $d->articulo['codigo_articulo'])->first();
                        $des = Descargo::where('id_detalle','=',$d->id)->first();
                        if($des){
                            //No guardara la transaccion
                        }elseif ($a->existencia >= $d->cantidad_entregada) {
                            $transaccion = new Transaccion();
                            $descargo = new Descargo();

                            $existencia_anterior = $a->existencia;
                            $existencia_nueva = $a->existencia - $d->cantidad_entregada;
                            $precio_unitario = $a->precio_unitario;

                            $transaccion->cantidad = $d->cantidad_entregada;
                            $transaccion->pre_unit = $precio_unitario;
                            $transaccion->fecha_registro = Date::now();
                            $transaccion->codigo_articulo = $d->articulo_id;
                            $transaccion->exis_ant = $existencia_anterior;
                            $transaccion->exis_nueva = $existencia_nueva;
                            $transaccion->save();
                            $descargo->id_descargo = $transaccion->id_transaccion;
                            $descargo->id_detalle = $d->id;
                            $descargo->save();
                            $a->existencia = $existencia_nueva;
                            $a->update();
                        }
                        $requisicion->update([
                            'estado' => 'aprobada',
                            'fecha_entrega' => Date::now(),
                            'financiero_id' => Auth::User()->id,
                        ]);
                    }
            }//fin del else

            return redirect()->route('requisicion-listar');
        }catch (Exception $ex){
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }
}
