<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;
use Exception;
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
use Session;
use DB;
//use Elibyy\TCPDF\Facades\TCPDF;
use TCPDF;



class ReporteController extends Controller
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
        try{
            return view('Reportes.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }
    //Carga la vista con el formulario solicitando la fecha de inicio y de fin
    public function kardexForm(){
        try{
            return view('Reportes.kardexForm');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    //Genera el kardex basado en una fecha de inicio y una de fin
    public function kardex(Request $request){
        $this->validate($request,[
            'fechainicio' => 'required',
            'fechafin' => 'required',
        ]);
        try{

            $fechaInicio = new Date($request->input('fechainicio'));
            $fechaFin = new Date($request->input('fechafin'));
            $fechaAhora = new Date();
            if( $fechaInicio > $fechaFin){
                flash('La fecha de inicio debe de ser menor o igual a la fecha de fin','danger');
                return redirect()->back();
            }elseif($fechaInicio > $fechaAhora || $fechaFin > $fechaAhora) {
                flash('Ingrese una fecha valida, que sea a lo sumo la fecha actual.','danger');
                return redirect()->back();
            }else{
                    $desde = $fechaInicio->format('d/m/Y ');
                    $hasta = $fechaFin->format('d/m/Y ');
                    $transacciones = Transaccion::whereBetween('fecha_registro',[$request->input('fechainicio'),$request->input('fechafin')])->orderBy('id_transaccion', 'asc')->get();

                    $view = \View::make('Reportes.kardex',['transacciones' => $transacciones,'desde'=>$desde,'hasta'=>$hasta]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Kardex');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    //Margenes
                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'kardex_del_'.$desde.'_al_'.$hasta.'.pdf';
                    $pdf->Output($nombre);

                }

        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }
    //Solicita informacion sobre como elaborar el reportea actual de existencias
    public function existenciaForm(){
        try{
            return view('Reportes.existenciaForm');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function existencia(Request $request){
        $this->validate($request,[
            'incluir' => 'required',
            'color' => 'required'
        ]);
        try{
            $fecha = Date::now()->format('d/m/Y');
            $color = $request->input('color');
            if($request->input('incluir') == 'todos'){
                $articulos = Articulo::orderBy('id_especifico','asc')->orderBy('created_at','asc')->get();

                //USANDO TCPDF
                $view = \View::make('Reportes.existencias',['articulos'=>$articulos,'fecha'=>$fecha,'color'=>$color]);
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(279.4, 216), true, 'UTF-8', false);
                $pdf->SetTitle('Existencia');
                $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));

                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->AddPage('L');
                $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                //$pdf->SetHeaderMargins(15,15,15);
                $pdf->SetFooterMargin(15);

                $pdf->setPrintFooter(true);
                //Margenes
                $pdf->SetX(10);
                $pdf->SetLeftMargin(10);
                $pdf->SetRightMargin(10);
                $pdf->SetTopMargin(17);

                //Margenes de los encabezados

                $pdf->setCellPaddings('1','2','1','2');
                $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->writeHTML($html, true, false, true, false, '');

                $nombre = 'existencias_al_'.$fecha.'.pdf';
                $pdf->Output($nombre);

            }elseif ($request->input('incluir')=='nocero'){
                $articulos = Articulo::where('existencia','>',0)->orderBy('id_especifico','asc')->orderBy('created_at','asc')->get();

                //USANDO TCPDF
                $view = \View::make('Reportes.existencias',['articulos'=>$articulos,'fecha'=>$fecha,'color'=>$color]);
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(279.4, 216), true, 'UTF-8', false);
                $pdf->SetTitle('Existencia');
                $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->AddPage('L');
                $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                $pdf->setPrintFooter(true);

                //Margenes
                $pdf->SetFooterMargin(15);
                $pdf->SetX(10);
                $pdf->SetLeftMargin(10);
                $pdf->SetRightMargin(10);
                $pdf->SetTopMargin(17);


                $pdf->setCellPaddings('1','2','1','2');
                $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->writeHTML($html, true, false, true, false, '');

                $nombre = 'existencias_al_'.$fecha.'.pdf';
                $pdf->Output($nombre);
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function consolidadoExistenciaForm(){
        try{
            return view('Reportes.consolidadoExistenciaForm');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function consolidadoExistencia( Request  $request){
        $this->validate($request,[
            'fechainicio' => 'required',
            'fechafin' => 'required',
        ]);
        try{
            $fechaInicio = new Date($request->input('fechainicio'));
            $fechaFin = new Date($request->input('fechafin'));
            $fechaAhora = new Date();
            if( $fechaInicio > $fechaFin){
                flash('La fecha de inicio debe de ser menor o igual a la fecha de fin','danger');
                return redirect()->back();
            }elseif($fechaInicio > $fechaAhora || $fechaFin > $fechaAhora){
                flash('Ingrese una fecha valida, que sea a lo sumo la fecha actual.','danger');
                return redirect()->back();
            }else{
                $desde = $fechaInicio->format(' d/m/Y ');
                $hasta = $fechaFin->format(' d/m/Y ');

                $todoslosArticulos = Articulo::orderBy('id_especifico','asc')->orderBy('created_at','asc')->get();

                //Traemos todos los productos que han tenido transacciones en ese rango de fechas

                //1$artr = DB::table('transaccion',['codigo_articulo'])->whereBetween('fecha_registro',[$request->input('fechainicio'),$request->input('fechafin')])->get();
                //1$art = $this->noRepetidos($artr);
                $transacciones = array();
                //1 foreach ($art as $codigo){

                foreach ($todoslosArticulos as $a){ //a se ha usado en vez de codigo por facilidad
                    $elemento = array();
                    //$a = Articulo::where('codigo_articulo','=',$codigo->codigo_articulo)->first();
                    $elemento['especifico'] = $a->id_especifico;
                    $elemento['codigo'] = $a->getCodigoArticuloReporte();
                    $elemento['articulo'] = $a->nombre_articulo;
                    $elemento['unidad'] = $a->unidad->nombre_unidadmedida;

                    //Revisamos las transacciones
                    //1  $tran = Transaccion::where('codigo_articulo','=',$codigo->codigo_articulo)->whereBetween('fecha_registro',[$request->input('fechainicio'),$request->input('fechafin')])->get();


                    $tran = Transaccion::where('codigo_articulo','=',$a->codigo_articulo)->whereBetween('fecha_registro',[$request->input('fechainicio'),$request->input('fechafin')])->get();
                    if(count($tran)>0) {
                        $tranInicial = new Transaccion();
                        $cant = $tran->count();
                        $cont = 0;
                        $tranInicial = $tran[0];

                        foreach ($tran as $t) {
                            if ($t->id_transaccion < $tranInicial->id_transaccio) {
                                $tranInicial = $t;
                            }
                        }
                        //Creamos el estado inicial
                        $cantidadi = 0;
                        $precioi = 0.00;
                        $montoi = 0.00;
                        if ($tranInicial->ingreso) {
                            $cantidadi = $tranInicial->exis_ant;
                            $precioi = $tranInicial->ingreso->pre_unit_ant;
                            $montoi = $cantidadi * $precioi;
                        } else {

                            $cantidadi = $tranInicial->exis_ant;
                            $precioi = $tranInicial->pre_unit;
                            $montoi = $cantidadi * $precioi;
                        }
                        //Le asignamos el estado inicial al elemento
                        $elemento['cantidadi'] = $cantidadi;
                        $elemento['precioi'] = number_format($precioi, 4, '.', '');
                        $elemento['montoi'] = number_format($montoi, 4, '.', '');

                        $cantidade = 0;
                        $precioe = 0.00;
                        $montoe = 0.00;

                        $cantidads = 0;
                        $precios = 0.00;
                        $montos = 0.00;

                        $cantidadf = 0;
                        $preciof = 0.00;
                        $montof = 0.00;
                        //Hacemos el calculo para el ingreso
                        $cantidadIngresos = 0;
                        $montoIngresos = 0;
                        $cantidadEgresos = 0;
                        $montoEgresos = 0.00;

                        foreach ($tran as $t) {
                            if ($t->ingreso) {
                                $cantidadIngresos = $cantidadIngresos + $t->cantidad;
                                $montoIngresos = $montoIngresos + ($t->cantidad * $t->pre_unit);
                            } else {
                                $cantidadEgresos = $cantidadEgresos + ($t->cantidad);
                                $montoEgresos = $montoEgresos + ($t->cantidad * $t->pre_unit);
                            }
                        }

                        //le agregamos las entradas y salidas al elemento
                        if ($cantidadIngresos != 0) {
                            $elemento['cantidade'] = $cantidadIngresos;
                            $elemento['precioe'] = number_format(($montoIngresos / $cantidadIngresos), 4, '.', '');
                            $elemento['montoe'] = number_format($montoIngresos, 4, '.', '');


                        } else {
                            $elemento['cantidade'] = $cantidadIngresos;
                            $elemento['precioe'] = number_format($precioe, 4, '.', '');
                            $elemento['montoe'] = number_format($montoIngresos, 4, '.', '');
                        }
                        if ($cantidadEgresos != 0) {
                            $elemento['cantidads'] = $cantidadEgresos;
                            $elemento['precios'] = number_format(($montoEgresos / $cantidadEgresos), 4, '.', '');
                            $elemento['montos'] = number_format($montoEgresos, 4, '.', '');

                        } else {
                            $elemento['cantidads'] = $cantidadEgresos;
                            $elemento['precios'] = number_format($precios, 4, '.', '');
                            $elemento['montos'] = number_format($montoEgresos, 4, '.', '');

                        }


                        $cantidadf = (int)$elemento['cantidadi'] + (int)$elemento['cantidade'] - (int)$elemento['cantidads'];
                        $montof = ($montoi + $montoIngresos) - ($montoEgresos);
                        if ($cantidadf == 0 && $montof == 0.00) {
                            $preciof = 0.00;
                        } else {
                            $preciof = ($montof / $cantidadf);
                        }


                        $elemento['cantidadf'] = $cantidadf;
                        $elemento['preciof'] = number_format($preciof, 4, '.', '');
                        $elemento['montof'] = number_format($montof, 4, '.', '');


                        $transacciones[] = $elemento;
                    }else{
                        //comprueba si hay transacciones anteriores
                        $tran = Transaccion::where('codigo_articulo','=',$a->codigo_articulo)->where('fecha_registro','<',$request->input('fechainicio'))->get();
                        if(count($tran) > 0){
                            $tranFinal = $tran[0];
                            //Determinamos la transaccion final
                            foreach ($tran as $t) {
                                if ($t->id_transaccion > $tranFinal->id_transaccio) {
                                    $tranFinal = $t;
                                }
                            }


                            if($tranFinal->ingreso){
                                //Todos los datos de los ingresos
                                $cantidadi = $tranFinal->exis_nueva;
                                $precioi = $tranFinal->ingreso->pre_unit_nuevo;
                                $montoi = $cantidadi * $precioi;

                                $elemento['cantidadi'] = $cantidadi;
                                $elemento['precioi'] = number_format($precioi, 4, '.', '');
                                $elemento['montoi'] = number_format($montoi, 4, '.', '');

                                $cantidade = 0;
                                $precioe = 0.00;
                                $montoe = 0.00;

                                $cantidads = 0;
                                $precios = 0.00;
                                $montos = 0.00;

                                $cantidadf = $cantidadi;
                                $preciof = $precioi;
                                $montof = $montoi;
                                //Hacemos el calculo para el ingreso
                                //$cantidadIngresos = 0;
                                //$montoIngresos = 0;
                                //$cantidadEgresos = 0;
                                //$montoEgresos = 0.00;

                                $elemento['cantidade'] = $cantidade;
                                $elemento['precioe'] = number_format($precioe, 4, '.', '');
                                $elemento['montoe'] = number_format($montoe, 4, '.', '');
                                $elemento['cantidads'] = $cantidads;
                                $elemento['precios'] = number_format($precios, 4, '.', '');
                                $elemento['montos'] = number_format($precios, 4, '.', '');
                                $elemento['cantidadf'] = $cantidadf;
                                $elemento['preciof'] = number_format($preciof, 4, '.', '');
                                $elemento['montof'] = number_format($montof, 4, '.', '');

                            }else{
                                $cantidadi = $tranFinal->exis_nueva;
                                $precioi = $tranFinal->descargo->pre_unit_nuevo;
                                $montoi = $cantidadi * $precioi;

                                $elemento['cantidadi'] = $cantidadi;
                                $elemento['precioi'] = number_format($precioi, 4, '.', '');
                                $elemento['montoi'] = number_format($montoi, 4, '.', '');

                                $cantidade = 0;
                                $precioe = 0.00;
                                $montoe = 0.00;

                                $cantidads = 0;
                                $precios = 0.00;
                                $montos = 0.00;

                                $cantidadf = $cantidadi;
                                $preciof = $precioi;
                                $montof = $montoi;
                                //Hacemos el calculo para el ingreso
                                //$cantidadIngresos = 0;
                                //$montoIngresos = 0;
                                //$cantidadEgresos = 0;
                                //$montoEgresos = 0.00;
                                $elemento['cantidade'] = $cantidade;
                                $elemento['precioe'] = number_format($precioe, 4, '.', '');
                                $elemento['montoe'] = number_format($montoe, 4, '.', '');
                                $elemento['cantidads'] = $cantidads;
                                $elemento['precios'] = number_format($precios, 4, '.', '');
                                $elemento['montos'] = number_format($precios, 4, '.', '');
                                $elemento['cantidadf'] = $cantidadf;
                                $elemento['preciof'] = number_format($preciof, 4, '.', '');
                                $elemento['montof'] = number_format($montof, 4, '.', '');

                            }

                            $existenciaNoCero = (int)$elemento['cantidadi'];
                            $precioNoCero = (float)$elemento['precioi'];

                            //Si la existencia y el precio no es cero entonces lo agregamos al reporte
                            if($existenciaNoCero > 0 && $precioNoCero != 0.00){
                                $transacciones[] = $elemento;
                            }else{
                                //No lo agregamos
                            }


                        }else{
                            //No Ha tenido ningun movimiento hasta la fecha, por tanto no es agregado
                        }


                    }

                }

                $transacciones = $this->ordenar($transacciones);
                $especificos = $this->especificos($transacciones);
                $espNoRepetidos = $this->especificosNoRepetidos($especificos);
                $transacciones = $this->resumir($transacciones,$especificos,$espNoRepetidos);

                //USANDO TCPDF
                $view = \View::make('Reportes.consolidadoExistencia',['transacciones'=>$transacciones,'desde'=>$desde,'hasta'=>$hasta]);
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                $pdf->SetTitle('Consolidado de existencias');
                $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->AddPage('L');
                $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                ///$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                //Margenes
                $pdf->SetFooterMargin(15);
                $pdf->SetX(10);
                $pdf->SetLeftMargin(10);
                $pdf->SetRightMargin(10);
                $pdf->SetTopMargin(17);

                $pdf->setPrintFooter(true);

                $pdf->setCellPaddings('1','3','1','3');
                $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                $pdf->writeHTML($html, true, false, true, false, '');

                $nombre = 'consolidado_existencia_del_'.$desde.'_al_'.$hasta.'.pdf';

                $pdf->Output($nombre);

            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    //Retorna los codigos de los articulos sin repetir
    private static function noRepetidos($codigos){
        $nor = array();
        foreach ($codigos as $cod){
            $cont = 0;
            foreach ($nor as $n){
                //si ya existe en el arreglo $nor entonces aumentamos el contador
                if($n->codigo_articulo == $cod->codigo_articulo){
                    $cont = $cont + 1;
                }
            }
            //Si no esta en $nor lo agregamos
            if($cont == 0){
                $nor[] = $cod;
            }
        }
        return $nor;
    }

    private static function ordenar($transacciones){
        $cant = count($transacciones);
        $i = 0;
        $j = 0;
        $aux = array();
        for ($i= 0; $i < $cant; $i++){
            for ($j= 0; $j < $cant - 1; $j++){
                if((int)$transacciones[$j]['especifico']> (int)$transacciones[$j+1]['especifico']){
                    $aux = $transacciones[$j+1];
                    $transacciones[$j+1] = $transacciones[$j];
                    $transacciones[$j] = $aux;
                }

            }
        }
        return $transacciones;
    }

    private static function especificos($transacciones){
        $especificos = array();
        foreach ($transacciones as $t){
            $especificos[] = $t['especifico'];
        }
        return $especificos;
    }

    private static function especificosNoRepetidos($especificos){
        $nor = array();
        foreach ($especificos as $cod){
            $cont = 0;
            foreach ($nor as $n){
                //si ya existe en el arreglo $nor entonces aumentamos el contador
                if($n == $cod){
                    $cont = $cont + 1;
                }
            }
            //Si no esta en $nor lo agregamos
            if($cont == 0){
                $nor[] = $cod;
            }
        }
        return $nor;
    }

    private static function  resumir($transacciones,$especificos,$espNoRep){

        $resumen = array();
        $elemento = array();
        $cant = count($especificos);

        foreach ($espNoRep as $n){
            $cont = 0;
            for($i = 0; $i < $cant ; $i++){
                if($n == $especificos[$i]){
                    $cont = $cont + 1;
                }
            }
            $elemento[] = $cont;
        }

        foreach ($espNoRep as $nr){
            $cantidadi = 0;
            $precioi = 0.00;
            $montoi = 0.00;

            $cantidade = 0;
            $precioe = 0.00;
            $montoe = 0.00;

            $cantidads = 0;
            $precios = 0.00;
            $montos = 0.00;

            $cantidadf = 0;
            $preciof = 0.00;
            $montof = 0.00;

            foreach ($transacciones  as $t){
                if($t['especifico'] == $nr){
                    //agregamos a resumen la transaccion
                    $resumen[] = $t;

                    //Resumimos los valores

                    $cantidadi = $cantidadi + (int)$t['cantidadi'];
                    $precioi = 0.00;
                    $montoi = $montoi + (float)$t['montoi'];

                    $cantidade = $cantidade + (int)$t['cantidade'];
                    $precioe = 0.00;
                    $montoe = $montoe + (float)$t['montoe'];

                    $cantidads = $cantidads + (int)$t['cantidads'];
                    $precios = 0.00;
                    $montos = $montos + (float)$t['montos'];

                    $cantidadf = $cantidadf + (int)$t['cantidadf'];
                    $preciof = 0.00;
                    $montof = $montof + (float)$t['montof'];

                }
            }

            $elemento = array();
            $elemento['especifico'] = 'r';
            $elemento['codigo'] = 'r';
            $elemento['articulo'] = 'r';
            $elemento['unidad'] = 'r';
            $elemento['cantidadi'] = $cantidadi;

            $elemento['montoi'] = number_format($montoi,4,'.','');
            if($cantidadi == 0 && $montoi==0.00){
                $elemento['precioi']=number_format(0.00,4,'.','');
            }else{
                $elemento['precioi'] = number_format(($montoi / $cantidadi),4,'.','');
            }



            $elemento['cantidade'] = $cantidade;
            $elemento['montoe'] = number_format($montoe,4,'.','');
            if($cantidade == 0 && $montoe==0.00){
                $elemento['precioe']=number_format(0.00,4,'.','');
            }else{
                $elemento['precioe'] = number_format($montoe / $cantidade,4,'.','');
            }


            $elemento['cantidads'] = $cantidads;
            $elemento['montos'] = number_format($montos,4,'.','');
            if($cantidads == 0 && $montos==0.00){
                $elemento['precios']=number_format(0.00,4,'.','');
            }else{
                $elemento['precios'] = number_format(($montos / $cantidads),4,'.','') ;
            }

            number_format(($montof / $cantidadf),4,'.','');

            $elemento['cantidadf'] = $cantidadf;
            $elemento['montof'] = number_format(($montof),4,'.','');
            if($cantidadf == 0 && $montof==0.00){
                $elemento['preciof']=number_format(0.00,4,'.','');
            }else{
                $elemento['preciof'] = number_format(($montof / $cantidadf),4,'.','');
            }

            $resumen[] = $elemento;

        }
        return $resumen;

    }

    //Captura informacion del historial de producto
    public function historialProductoForm(){
        try{
            $articulos = Articulo::orderBy('nombre_articulo','asc')->get();
            return view('Reportes.historialProductoForm',['articulos'=>$articulos]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function historialProducto(Request $request)
    {
        $this->validate($request, [
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'producto' => 'required | exists:articulo,codigo_articulo',

        ]);
        try{
            $fechaInicio = new Date($request->input('fechainicio'));
            $fechaFin = new Date($request->input('fechafin'));
            $fechaAhora = new Date();
            if ($fechaInicio > $fechaFin) {
                flash('La fecha de inicio debe de ser menor o igual a la fecha de fin', 'danger');
                return redirect()->back();
            }elseif($fechaInicio > $fechaAhora || $fechaFin > $fechaAhora){
                flash('Ingrese una fecha valida, que sea a lo sumo la fecha actual.','danger');
                return redirect()->back();
            }else{
                $desde = $fechaInicio->format(' d/m/Y ');
                $hasta = $fechaFin->format(' d/m/Y ');
                //Traemos todos los productos que han tenido transacciones en ese rango de fechas
                $articulo = Articulo::findOrFail($request->input('producto'));
                $transacciones = Transaccion::where('codigo_articulo','=',$request->input('producto'))->whereBetween('fecha_registro', [$request->input('fechainicio'), $request->input('fechafin')])->get();

                //USANDO TCPDF
                $view = \View::make('Reportes.historialProducto',['transacciones'=>$transacciones,'desde'=>$desde,'hasta'=>$hasta,'articulo'=>$articulo]);
                $html = $view->render();

                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                $pdf->SetTitle('Historial');
                $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                $pdf->AddPage('L');
                $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                //$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                $pdf->setPrintFooter(true);
                //$pdf->SetCellPadding('1');
                //Margenes
                $pdf->SetFooterMargin(15);
                $pdf->SetX(10);
                $pdf->SetLeftMargin(10);
                $pdf->SetRightMargin(10);
                $pdf->SetTopMargin(17);

                $pdf->setCellPaddings('1','3','1','3');
                $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 148));
                //$pdf->Footer();
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->writeHTML($html, true, false, true, false, '');

                $nombre = 'Historial_de_'.$articulo->nombre_articulo.'_del_'.$desde.'_al_'.$hasta.'.pdf';
                $pdf->Output($nombre);
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }


}
