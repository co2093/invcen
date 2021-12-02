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
use TCPDF;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use sig\Models\ExistenciaReactivo;
use sig\Models\MenosReactivo;



class DetalleRequisicionController extends Controller
{
     public function __construct()
    {
        try {
            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }

    //Esta funcion muestra la vista de agregar articulo a la requisicion cuando el administrador de
    //departamento la  esta creando
    public function index()
    {
        try{
         $articulos = Articulo::where('existencia','>','0')->orderBy('id_especifico','asc')->orderBy('created_at','asc')->get();
         return view('Requisicion.agregar',['articulos'=>$articulos]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

   
    //agregar observaciones a la requisicion cuando el administrador de departamento la esta creando
    //o cuando el administrador de la bodega la esta editando
    public function observacion($id)
    {
        try {
            $requisicion = Requisicion::FindOrFail($id);
            return view('Requisicion.observaciones', ['requisicion' => $requisicion]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    //store se utilizó para almacenar observaciones sobre la requisicion de parte del depto
    public function store(Request $request)
    {
        try{
       $requisicion  = Requisicion::FindOrFail($request->id);
       
        if(Auth::User()->perfil['name'] == 'DEPARTAMENTO')
        {
            $requisicion->update([
                'observacion' => $request->observaciones,
            ]);
            return redirect()->route('requisicion-show'); 
        }
        else{
            $requisicion->update([
                'observacion' => $request->observaciones,
            ]);
            flash('Observacion guardada exitosamente', 'success');
            return redirect()->route('requisicion.detalle.edit',['id'=>$requisicion->id]);
        }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function show($id)
    {
        try{
        $req  = Requisicion::FindOrFail($id);
        $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();

        return view('Requisicion.bodega_ver',['detalle'=>$detalle,'requisicion'=>$req]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function edit($id)
    {
        try{
        $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
        $req  = Requisicion::FindOrFail($id);

        if(Auth::User()->perfil['name'] == 'DEPARTAMENTO')
        {
            return view('Requisicion.departamento_ver',['detalle'=>$detalle,'requisicion'=>$req]);
        }       
        else
        {
            if(Auth::User()->perfil['name'] == 'ADMINISTRADOR FINANCIERO')
            {
                $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
                return view('Requisicion.financiero_ver',['detalle'=>$detalle,'requisicion'=>$req]);  
            }
            else
            {
                return view('Requisicion.actualizar',['detalle'=>$detalle,'requisicion'=>$req]);  
            } 
        }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
        
    }

    public function update(Request $request, $id)
    {  
         $this->validate($request,[
            'cantidad' => 'required |integer|min:1|max:1000',            
        ]);
        try
        {
            $d = DetalleRequisicion::FindOrFail($id); 

            /*si el articulo es reacitvo*/
            if($d->articulo['es_reactivo']=='S')
            {
                $asignacion = 0;
                for($v=0; $v<count($request->codasignacion);$v++)
                {
                    $asignacion = $asignacion + $request->codasignacion[$v];
                }
                if($request->cantidad != $asignacion)
                {
                    flash('La cantidad aprobada y la suma de cantidades asignadas no coinciden', 'danger');
                    return back();
                }               
            }
            /***/
            if($d->requisicion['estado']=='aprobada')
             {
                return redirect()->route('requisicion-listar');  
             }
            else
            {//inicia else si no esta aprobada


                 $lista_requisiciones = Requisicion::where('estado','actualizada')->get();         
                
                 $cantidad_aprobada = 0.0;
                 foreach ($lista_requisiciones as $listaR)
                 {
                    foreach ($listaR->detalles as $listaD)
                    {
                        if($listaD->articulo_id==$d->articulo_id && $listaD->id!=$d->id){
                            $cantidad_aprobada = $cantidad_aprobada + $listaD->cantidad_entregada;
                        }
                    }    
                 } 
                $quedan =  $d->articulo['existencia'] - $cantidad_aprobada;    
                $cantidad_aprobada = $cantidad_aprobada + $request->cantidad;        
                
                    if($d->articulo['existencia'] < $cantidad_aprobada)
                    {
                    flash('Unicamente '.$quedan.' Existencias sin reservar', 'danger');
                    }
                    else
                    {            
                        $d->update([
                        'cantidad_entregada' => $request->cantidad,
                        ]);
                          /*si el articulo es reacitvo*/
                        if($d->articulo['es_reactivo']=='S')
                        {   
                            MenosReactivo::where('id_detalle_requisicion',$d->id)->delete();

                            for($w=0; $w<count($request->codasignacion);$w++)
                            {
                                $avaciar = $request->codasignacion[$w];
                                $fechavaciar = $request->codfechas[$w];

                                $menosR = new MenosReactivo();
                                $menosR->id_detalle_requisicion = $d->id;
                                $menosR->codigo_articulo = $d->articulo_id;
                                $menosR->fecha_expira = $fechavaciar;
                                $menosR->cantidad = $avaciar;
                                $menosR->save();
                                
                            }
                                           
                        }
                        /***/       
                    }
            }//finaliza else si no esta aprobada
              return back();
         }catch (Exception $ex)
         {
             return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
         }
    }

    public function aprobar(Request $request,$id)
    {
        $this->validate($request,[
            'ordenrequisicion' => 'required | max:8',
        ]);

        try{
            $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
            $requisicion = Requisicion::where('id','=',$id)->first();
            $cant = $detalle->count();
            $cont = 0;
            foreach ($detalle as $de) {
                if($de->cantidad_entregada == 0){
                    $cont = $cont + 1;
                }
            }

            if($cont == $cant){
                flash('Nota: No se ha aprobado ningun producto','danger');
                return redirect()->back();
            }else {

                if (Auth::User()->perfil['name'] == 'ADMINISTRADOR BODEGA') {
                    $requisicion->update([
                        'estado' => 'actualizada',
                        'bodega_id' => Auth::User()->id,
                        'ordenrequisicion'=>$request->input('ordenrequisicion')
                    ]);
                    flash('Solicitud aprobada exitosamente', 'success');
                    return redirect()->route('requisicion.detalle.show',['id' => $requisicion->id]);

                } elseif (Auth::User()->perfil['name'] == 'ADMINISTRADOR FINANCIERO') {
                    foreach ($detalle as $d) {
                        $a = Articulo::where('codigo_articulo', $d->articulo['codigo_articulo'])->first();
                        $des = Descargo::where('id_detalle', '=', $d->id)->first();
                        if ($des) {
                            //No guardara la transaccion
                        } elseif ($a->existencia >= 1) {
                            $transaccion = new Transaccion();
                            $descargo = new Descargo();

                            $existencia_anterior = $a->existencia;
                            $existencia_nueva = $a->existencia - $d->cantidad_entregada;
                            $precio_unitario = $a->precio_unitario;

                            if ($a->existencia < $d->cantidad_entregada) {
                                $existencia_nueva = 0;
                                $a->precio_unitario = 0.00;
                                $d->cantidad_entregada = $a->existencia;
                                $d->update();
                            }

                            $transaccion->cantidad = $d->cantidad_entregada;
                            $transaccion->pre_unit = $precio_unitario;
                            $transaccion->fecha_registro = Date::now();
                            $transaccion->codigo_articulo = $d->articulo_id;
                            $transaccion->exis_ant = $existencia_anterior;
                            $transaccion->exis_nueva = $existencia_nueva;
                            $transaccion->save();
                            $descargo->id_descargo = $transaccion->id_transaccion;
                            $descargo->id_detalle = $d->id;
                            $descargo->pre_unit_nuevo = $precio_unitario;
                            if ($existencia_nueva == 0) {
                                $a->precio_unitario = 0.00;
                                $descargo->pre_unit_nuevo = 0.00;
                            }
                            $a->existencia = $existencia_nueva;
                            $a->update();
                            $descargo->save();
                        }
                        $requisicion->update([
                            'estado' => 'aprobada',
                            'fecha_entrega' => Date::now(),
                            'financiero_id' => Auth::User()->id,
                        ]);

                        /*if(es_reactivo)*/
                        if($a->es_reactivo == 'S')
                        {
                            $asignaciones = MenosReactivo::where('id_detalle_requisicion',$d->id)->get();
                            foreach ($asignaciones as $asignacion) 
                            {
                                $avaciar = $asignacion->cantidad;
                                $fechavaciar = $asignacion->fecha_expira;
                                while ($avaciar > 0) 
                                {
                                    $exist = ExistenciaReactivo::where('codigo_articulo',$d->articulo_id)
                                        ->where('fecha_expira',$fechavaciar)
                                        ->where('cantidad','>',0)->first();
                                    if($exist->cantidad<$avaciar)
                                    {
                                        $avaciar= $avaciar - $exist->cantidad;                                    

                                        $exist->cantidad = 0;
                                        $exist->save();
                                    }
                                    else{                                        
                                        $exist->cantidad = $exist->cantidad - $avaciar;                                      

                                        $avaciar = 0;
                                        $exist->save();
                                    }
                                }
                            }
                            MenosReactivo::where('id_detalle_requisicion',$d->id)->delete();
                        }
                    }
                    flash('Solicitud aprobada exitosamente', 'success');

                }//fin del else


                return redirect()->route('requisicion-listar');
            }
        }catch (Exception $ex){
            return ($ex->getMessage().'Codigo:'.$ex->getCode());
        }
    }

    public function imprimir($id){
        try{
            $req  = Requisicion::FindOrFail($id);
            $admin_financiero  = User::where('id','=',$req->financiero_id)->first();

            $admin_bodega = User::where('id','=',$req->bodega_id)->first();
            $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
            $date = new Date($req->fecha_entrega);
            $fecha = array('fecha' => $date->format('l, j \d\e F \d\e Y'),'numero'=>substr($req->id,2).'/'.$date->format('Y'));
            $usuarios = array('bodega'=>$admin_bodega->name,'financiero'=>$admin_financiero->name);

            $total=0;
            foreach ($detalle as $d) {
                $total += $d->articulo['precio_unitario']*$d->cantidad_entregada;
            }

            //return view('Requisicion.imprimir',['detalle'=>$detalle,'requisicion'=>$req,'fecha'=>$fecha,'usuarios'=>$usuarios, 'total'=>$total]);
            $nombre = 'requisicion_'.substr($req->id,2).'_'.$date->format('Y').'.pdf';


            //$pdf = PDF::loadView('Requisicion.imprimir',['detalle'=>$detalle,'requisicion'=>$req,'fecha'=>$fecha,'usuarios'=>$usuarios, 'total'=>$total]);
            //return $pdf->stream($nombre);

            //TCPDF
            $view = \View::make('Requisicion.imprimir',['detalle'=>$detalle,'requisicion'=>$req,'fecha'=>$fecha,'usuarios'=>$usuarios, 'total'=>$total]);
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(279.4, 216), true, 'UTF-8', false);
            $pdf->SetTitle('Requisicion');
            $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->AddPage();
            $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->setPrintFooter(true);
            //$pdf->SetCellPadding('1');
            $pdf->setCellPaddings('1','2','1','2');
            $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));
            //$pdf->Footer();
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output($nombre);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function reporteindvPlanPDF($id){
        
        /*$plancompras = DB::table('articulo')
        ->join('detalle_requisicions', 'articulo.codigo_articulo', '=', 'detalle_requisicions.articulo_id')
        ->join('requisicions', 'requisicions.id', '=', 'detalle_requisicions.requisicion_id')
        ->join('unidad_medida', 'unidad_medida.id_unidad_medida', '=', 'articulo.id_unidad_medida')
        ->join('departments', 'departments.id', '=', 'requisicions.departamento_id')
        ->join('especificos', 'especificos.id', '=', 'articulo.id_especifico')
        ->select('especificos.id','codigo_articulo','nombre_articulo', 'nombre_unidadmedida', 'precio_unitario', 'cantidad_solicitada', 'departments.name','requisicions.id', 'observacion')
        ->where('detalle_requisicions.id', '=', [$id]);*/
        $req  = Requisicion::FindOrFail($id);
        $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();

        $view = \View::make('Requisicion.pdf_indv_Plan',['detalle'=>$detalle,'requisicion'=>$req]);
       // $view = \View::make('Requisicion.plandecompras', ['solicitudes' => $solicitudes]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras Individual');
                    $pdf->SetHeaderData('', '', '', 'Reporte de compra individual', array(0,0,0), array(52, 20, 44));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('P');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                   /* $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);*/


                    /*$pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));*/

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'reporte-individual-plandecompras.pdf';
                    $pdf->Output($nombre);
    }

    
    public function reporteindvPlanEXCEL($id){
        
        
        Excel::create('reporte-individual-plancompras', function($excel) {

          //  $req  = Requisicion::FindOrFail($id);
             $req = DB::table('requisicions')->where('id', $id)->get();
           // $detalle = DetalleRequisicion::where('requisicion_id','=',$id)->get();
             $detalle = DB::table('detalle_requisicions')->where('requisicion_id', $id)->get();
            //dd($id);
               
                $excel->sheet('plandecomprasIndividual', function($sheet) use($detalle) {
                    $sheet->row(2, ['', 'Plan de Compras Individual'
                    ]);
                    $sheet->row(4, ['', 'Plan de compras de:' ]);
                    $sheet->row(5, ['', 'Fecha de Solicitud:' ]);
                    $sheet->row(6, ['', 'Orden requisición nº:' ]);
                    $sheet->row(7, ['', 'Solicitud:' ]);
                    $sheet->row(8, [
                        'Especifico','Código Producto', 'Nombre del producto', 'Unidad de Medida', 'Cant. solicitada', 'Precio unitario ($)'
                    ]);
    
    
                    foreach($detalle as $index => $i) {                    
                           $sheet->row($index+9, [
                            $i->articulo->id_especifico, $i->articulo->getCodigoArticuloReporte(), $i->articulo['nombre_articulo'],$i->articulo['unidad']['nombre_unidadmedida'], $i->cantidad_solicitada,round($i->precio,2)
                        ]); 
                    }
                    
        
    
                });
    
            })->export('xlsx');
    }
   
}
