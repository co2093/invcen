<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use Jenssegers\Date\Date;
use sig\Http\Requests;
use sig\Models\Ingreso;
use sig\Models\Transaccion;
use sig\Models\Articulo;
use sig\Models\Article\Provider;
use sig\Models\Descargo;
use sig\Models\Estados;
use sig\Models\Equipo;
use sig\Models\ExistenciaReactivo;
use Exception;

use Auth;
use DB;


class IngresoController extends Controller
{
    public function __construct()
    {
        try{
            $this->middleware('auth');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function index(){
        try {
            $ingresos = Ingreso::orderBy('id_ingreso', 'asc')->get();
            return view('ingresos.index', ['ingresos' => $ingresos]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    //Agrega existencia a un prouducto
    public function create($codProducto){
        try {
            $proveedores = Provider::orderBy('nombre', 'asc')->get();
            $articulo = Articulo::findOrFail($codProducto);           

            $data['proveedores'] = $proveedores;
            $data['articulo'] = $articulo;
            
            return view('ingresos.addExistencia', $data);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function store(Request $request)
    {
        //Valida que los datos sean correctos
        $this->validate($request,[
            'producto' => 'required | exists:articulo,codigo_articulo',
            'proveedor' => 'required |integer | exists:providers,id',
            'fecha' => 'required',
            'cantidad' => 'required | integer|min:1',
            'precio' => 'required | numeric|min:0.00',
            'orden' =>'required | regex: /^[a-zA-Z()0-9\-\_]*$/ | max:15',
            'factura' =>'required | regex: /^[a-zA-Z0-9\-\_]*$/ | max:10',
        ]);


        $fechaAhora = new Date();
        $fechaIngreso = new Date($request->input('fecha'));
        if($fechaIngreso > $fechaAhora){
            flash('Ingrese una fecha valida, que sea a lo sumo la fecha actual.','danger');
            return redirect()->back();
        }
        try {

            $tran = Transaccion::where('cantidad','=',$request->input('cantidad'))->where('fecha_registro','=',$request->input('fecha'))->where('pre_unit','=',$request->input('precio'))->where('codigo_articulo','=',$request->input('producto'))->first();
            if($tran){
                flash('Ingreso ha sido guardado exitosamente', 'success');
                if ($request->input('mostrar') == 'ingresoindex') {
                    return redirect()->route('ingreso.index');
                } else {
                    return redirect()->route('articulo.index');
                }
            }else {
                $articulo = Articulo::where('codigo_articulo', '=', $request->input('producto'))->first();
                //precio anterior
                $precio_anterior = round($articulo->precio_unitario,4);
                //existenciaanterior
                $existencia_anterior = $articulo->existencia;
                //Existencia nueva
                $nuevaExistencia = $request->input('cantidad') + $existencia_anterior;
                //precio nuevo
                $nuevoPrecio = round((($precio_anterior * $existencia_anterior) + ($request->input('cantidad') * $request->input('precio'))) / $nuevaExistencia,4);

                $articulo->existencia = $nuevaExistencia;
                $articulo->precio_unitario = $nuevoPrecio;

                $transaccion = new Transaccion();
                $transaccion->cantidad = $request->input('cantidad');
                $transaccion->pre_unit = round($request->input('precio'),4);
                $transaccion->exis_ant = $existencia_anterior;
                $transaccion->exis_nueva = $nuevaExistencia;
                $transaccion->fecha_registro = $request->input('fecha');
                $transaccion->codigo_articulo = $request->input('producto');
                $transaccion->save();

                $ingreso = new Ingreso();
                $ingreso->id_proveedor = $request->input('proveedor');
                $ingreso->orden = $request->input('orden');
                $ingreso->num_factura = $request->input('factura');

                $ingreso->pre_unit_nuevo = $nuevoPrecio;
                $ingreso->pre_unit_ant = round($precio_anterior,4);

                if($articulo->es_reactivo=='S')
                {
                    $ingreso->marca = $request->marca;              
                    $ingreso->casa = $request->casa; 
                    $ingreso->fecha_expira = $request->fecha_expira;
                    
                    $existenciaR = new ExistenciaReactivo();
                    $existenciaR->codigo_articulo = $articulo->codigo_articulo;
                    $existenciaR->cantidad = $request->cantidad;
                    $existenciaR->fecha_expira = $request->fecha_expira;
                    $existenciaR->id_ingreso = $transaccion->id_transaccion; 
                    $existenciaR->save();                  
                }      

                
                $ingreso->id_ingreso = $transaccion->id_transaccion;
                $ingreso->save();
                $articulo->update();
                
                flash('Ingreso guardado exitosamente', 'success');
                if ($request->input('mostrar') == 'ingresoindex') {
                    return redirect()->route('ingreso.index');
                } else {
                    return redirect()->route('articulo.index');
                }
            }

        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }


    }



    public function show($idIngreso)
    {
        try{
            $ingreso = Ingreso::findOrFail($idIngreso);
            response()->json($ingreso);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
    public function detalle($idIngreso)
    {
        try{
            $ingreso = Ingreso::findOrFail($idIngreso);
            return response()->json(['fecha'=>$ingreso->transaccion->getFecha(),'articulo'=>$ingreso->transaccion->articulo->nombre_articulo,'unidad'=>$ingreso->transaccion->articulo->unidad->nombre_unidadmedida,'proveedor'=>$ingreso->proveedor->nombre,'telefono'=>$ingreso->proveedor->telefono,'email'=>$ingreso->proveedor->email,'vendedor'=>$ingreso->proveedor->vendedor,'especifico'=>$ingreso->transaccion->articulo->especifico->getEspecificoTitulo()]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }



    public function edit($idIngreso)
    {
        try{
            $ingreso = Ingreso::findOrFail($idIngreso);
            $proveedores = Provider::orderBy('nombre', 'asc')->get();
            return view('ingresos.edit',['ingreso'=>$ingreso,'proveedores'=>$proveedores]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $idIngreso)
    {
        //Valida que los datos sean correctos
        $this->validate($request,[
            'proveedor' => 'required |integer | exists:providers,id',
            'fecha' => 'required',
            'cantidad' => 'required | integer|min:1',
            'precio' => 'required | numeric|min:0.00',
            'orden' =>'required | regex: /^[a-zA-Z0-9()\-\_]*$/ | max:15',
            'factura' =>'required | regex: /^[a-zA-Z0-9\-\_]*$/ | max:10',
        ]);

        $fechaAhora = new Date();
        $fechaIngreso = new Date($request->input('fecha'));
        if($fechaIngreso > $fechaAhora){
            flash('Ingrese una fecha valida, que sea a lo sumo la fecha actual.','danger');
            return redirect()->back();
        }
        try{
            $ingreso = Ingreso::findOrFail($idIngreso);
            if($request->input('cantidad' ) == $ingreso->transaccion->cantidad && round($request->input('precio'),2) == round($ingreso->transaccion->pre_unit,2)){
                $ingreso->id_proveedor = $request->input('proveedor');
                $ingreso->orden = $request->input('orden');
                $ingreso->num_factura = $request->input('factura');
                $ingreso->transaccion->fecha_registro = $request->input('fecha');
                $ingreso->transaccion->update();
                $ingreso->update();
                flash('Ingreso actualizado exitosamente','success');

                //$ingresos = Ingreso::orderBy('id_ingreso', 'asc')->get();
                //return view('ingresos.index', ['ingresos' => $ingresos]);
                return redirect()->route('ingreso.index');

            }else{
                $ingresos = Ingreso::where('id_ingreso', '>', $idIngreso)->get();
                $ingresosDespues = "Transaccion numero";
                $cont =0;
                $descargos = Descargo::where('id_descargo', '>', $idIngreso)->get();
                $descargosDespues = "Transaccion numero";
                $contd = 0;
                //Se asegura que al actualizar el ingreso no haya habido otro ingreso posterior
                foreach ($ingresos as $ing){
                    if ($ing->transaccion->articulo->codigo_articulo == $ingreso->transaccion->articulo->codigo_articulo){
                        $ingresosDespues = $ingresosDespues.' '.$ing->id_ingreso.', fecha de registro '.$ing->transaccion->fecha_registro .'; Transaccion numero ';
                        $cont = $cont + 1;
                    }
                }
                //Se asegura que al actualizar el ingreso no haya habido algun descargo posterior que se hay hecho del ingreso
                //a actualizar
                foreach ($descargos as $des){
                    if ($des->transaccion->articulo->codigo_articulo == $ingreso->transaccion->articulo->codigo_articulo){
                        $descargosDespues = $descargosDespues.' '.$des->id_descargo.', fecha de registro '.$des->transaccion->fecha_registro .'; Transaccion numero ';
                        $contd = $contd + 1;
                    }
                }
                //Comprueba que no hubieron ingresos posteriores al mismo articulo
                if($cont>0){
                    $proveedores = Provider::orderBy('nombre', 'asc')->get();
                    flash('No puede actualizarse se han realizado las siguintes transacciones despues'.$ingresosDespues,'warning');
                    return view('ingresos.edit',['ingreso'=>$ingreso,'proveedores'=>$proveedores]);
                }elseif($contd > 0){
                    $proveedores = Provider::orderBy('nombre', 'asc')->get();
                    flash('No puede actualizarse se han realizado las siguintes transacciones despues'.$descargosDespues,'warning');
                    return view('ingresos.edit',['ingreso'=>$ingreso,'proveedores'=>$proveedores]);
                }
                else{
                    $articulo = Articulo::findOrFail($ingreso->transaccion->articulo->codigo_articulo);
                    if($articulo->existencia == $ingreso->transaccion->exis_nueva && round($articulo->precio_unitario,2) == round($ingreso->pre_unit_nuevo,2)){
                        $ingreso->id_proveedor = $request->input('proveedor');
                        $ingreso->transaccion->fecha_registro = $request->input('fecha');
                        $ingreso->orden = $request->input('orden');
                        $ingreso->num_factura = $request->input('factura');


                        $exis_anterior = $ingreso->transaccion->exis_ant;
                        $pre_unit_anterior = round($ingreso->pre_unit_ant,4);
                        $nuevaExistencia = $request->input('cantidad') + $exis_anterior;
                        $nuevoPrecio = round((($pre_unit_anterior * $exis_anterior) + ($request->input('cantidad') * $request->input('precio'))) / $nuevaExistencia,4);

                        $ingreso->transaccion->pre_unit = round($request->input('precio'),4);
                        $ingreso->transaccion->cantidad = $request->input('cantidad');
                        $ingreso->transaccion->exis_nueva = $nuevaExistencia;
                        $ingreso->pre_unit_nuevo = $nuevoPrecio;

                        $articulo->existencia = $nuevaExistencia;
                        $articulo->precio_unitario = $nuevoPrecio;

                        if($articulo->es_reactivo=='S')
                        {
                            $ingreso->marca = $request->marca;              
                            $ingreso->casa = $request->casa; 
                            $ingreso->fecha_expira = $request->fecha_expira;   

                            $existenciaReactivo = ExistenciaReactivo::where('id_ingreso',$ingreso->id_ingreso)->first();
                            if($existenciaReactivo)
                            {                      
                                $existenciaReactivo->cantidad = $request->cantidad;  
                                $existenciaReactivo->fecha_expira = $request->fecha_expira;                      
                                $existenciaReactivo->save();  
                            }             
                           
                        }

                        $ingreso->transaccion->update();
                        $ingreso->update();
                        $articulo->update();
                        flash('Ingreso actualizado exitosamente','success');
                        //$ingresos = Ingreso::orderBy('id_ingreso', 'asc')->get();
                        //return view('ingresos.index', ['ingresos' => $ingresos]);
                        return redirect()->route('ingreso.index');

                    }
                }
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }


    }

    public function delete($idIngreso){
        try {
            $ingreso = Ingreso::findOrFail($idIngreso);
            return view('ingresos.delete', ['ingreso' => $ingreso]);
        }catch (Exception $ex){
            return ($ex->getMessage().'Hola'.$ex->getCode());
        }
    }

    public function destroy($idIngreso)
    {
        try{
            $ingreso = Ingreso::findOrFail($idIngreso);
            $ingresos = Ingreso::where('id_ingreso', '>', $idIngreso)->get();
            $ingresosDespues = "Transaccion numero";
            $descargos = Descargo::where('id_descargo', '>', $idIngreso)->get();
            $descargosDespues = "Transaccion numero";
            $contd = 0;
            $cont =0;
            foreach ($ingresos as $ing){
                if ($ing->transaccion->articulo->codigo_articulo == $ingreso->transaccion->articulo->codigo_articulo){
                    $ingresosDespues = $ingresosDespues.' '.$ing->id_ingreso.', fecha de registro '.$ing->transaccion->fecha_registro .'; Transaccion numero ';
                    $cont = $cont + 1;
                }
            }
            foreach ($descargos as $des){
                if ($des->transaccion->articulo->codigo_articulo == $ingreso->transaccion->articulo->codigo_articulo){
                    $descargosDespues = $descargosDespues.' '.$des->id_descargo.', fecha de registro '.$des->transaccion->fecha_registro .'; Transaccion numero ';
                    $contd = $contd + 1;
                }
            }
            if($cont>0){
                flash('No puede eliminarse se han realizado las siguintes transacciones despues'.$ingresosDespues,'warning');
                return view('ingresos.delete',['ingreso'=>$ingreso]);

            }elseif ($contd > 0){
                flash('No puede eliminarse se han realizado las siguintes transacciones despues'.$descargosDespues,'warning');
                return view('ingresos.delete',['ingreso'=>$ingreso]);
            }else{
                $articulo = Articulo::findOrFail($ingreso->transaccion->articulo->codigo_articulo);
                if($articulo->existencia == $ingreso->transaccion->exis_nueva && round($articulo->precio_unitario,0) == round($ingreso->pre_unit_nuevo,0) ){
                    $transaccion = Transaccion::findOrFail($ingreso->id_ingreso);
                    $articulo->existencia = $ingreso->transaccion->exis_ant;
                    $articulo->precio_unitario = $ingreso->pre_unit_ant;

                     /*si es reactivo*/
                    if($articulo->es_reactivo=='S')
                    {
                        $existenciaR = ExistenciaReactivo::where('id_ingreso',$ingreso->id_ingreso)->first();
                        $existenciaR->delete();
                    }
                    /*fin de si es reactivo*/

                    $ingreso->delete();
                    $transaccion->delete();
                    $articulo->update();

                    flash('Ingreso eliminado exitosamente','success');
                    return redirect()->route('ingreso.index');

                }else{
                    flash('Error al eliminar el ingreso, hay otras transacciones que han afectado poder eliminar la entrada','danger');
                    return view('ingresos.delete',['ingreso'=>$ingreso]);
                }

            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
}
