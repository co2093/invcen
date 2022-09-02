<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Http\Requests;
use DB;
use sig\Models\Articulo;
use sig\Models\Especifico;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Response;
use sig\User;


class PlanComprasController extends Controller
{


    public function index(){
            
        $periodo = DB::table('periodo')->first();

        //dd($periodo);

        if($periodo->estado==1){
            $planDelUsuario = DB::table('plan_compras')
            ->where('user_id', '=', Auth::user()->id)
            ->where('estado', '=', "Pendiente")
            ->get();

            $proveedores = DB::table('providers')->get();            
            
            return view('plandecompras.index', compact('planDelUsuario', 'proveedores'));
        }else{

            return redirect()->route('plandecompras.error');
        }
                
    }


    public function consultarProductos(){

        $periodo = DB::table('periodo')->first();

        if($periodo->estado==1){

        $articulos = Articulo::all();

        return view('plandecompras.consultarproducto', compact('articulos'));

        }else{

            return redirect()->route('plandecompras.error');
        }
    }    


    public function agregarNuevo(){

        $periodo = DB::table('periodo')->first();
        $categorias = Especifico::all();
        $proveedores = DB::table('providers')->get();

        if($periodo->estado==1){

        return view('plandecompras.agregarproducto', compact('categorias', 'proveedores'));

        }else{

            return redirect()->route('plandecompras.error');
        }

    }

    public function store(Request $request){

        $e = DB::table('plan_compras')->where('nombre_producto', '=', $request->input('nombre_producto'))->where('estado','=','Pendiente')

        ->get();

        

       /* if($e){

       $fecha = Carbon::now();

       $request2 = array(
           $request->input('cantidad'), //0
            $request->input('nombre_producto'),  //1
           $request->input('especificaciones'),  //2
            $request->input('precio'),  //3
            $request->input('proveedor'),  //4
           $request->input('cotizacion'), //5
            $request->input('user_id'),  //6
          $request->input('categoria'),  //7
            $fecha,  //8
            'Pendiente' //9
        );

        return view('plandecompras.revision', compact('e', 'request2'));

       *}else{*/

        $fecha = Carbon::now();

        $p = $request->input('precio');

        if ($p == "") {
            // code...
            $p = 0.0;
        }

        if ($request->hasFile('cotizacion')) {

            $file = $request->file('cotizacion');              
            $nombreOriginal =  'cotizacion'.$fecha.Auth::user()->id.$file->getClientOriginalName(); 
             //$newName = "cotizacion/".$nombreOriginal;
             $file->move(public_path('cotizacion/'), $nombreOriginal);
            

        }

        $t = DB::table('providers')->where('telefono', '=', $request->input('telefono'))->first();
        $t1 = DB::table('providers')->where('nombre', '=', $request->input('nuevoproveedor'))->first();

        if ($t || $t1) {
            // code...
            flash('El proveedor nuevo ya existe, revisar en la lista', 'danger');
            return redirect()->back();


        }else{


        DB::table('plan_compras')->insert([
            'cantidad' => $request->input('cantidad'),
            'nombre_producto' => $request->input('nombre_producto'),
            'especificaciones' => $request->input('especificaciones'),
            'precio_unitario' => $p,
            'cotizacion' => $nombreOriginal,
            'proveedor'=>$request->input('proveedor'),
            'user_id' => $request->input('user_id'),
            'categoria' => $request->input('categoria'),
            'fecha' => $fecha,
            'estado' => 'Pendiente',
            'nuevoproveedor' => $request->input('telefono'),
            'unidad' => $request->input('unidadmedida'),
            'cantidad_aprobada' =>$request->input('cantidad'),
            'total' => $request->input('total') 
        ]);

        DB::table('providers')->insert([
            'nombre' => $request->input('nuevoproveedor'),
            'telefono' =>$request->input('telefono'),
            'direccion' => ' ',
            'vendedor' => ' '

        ]);

        flash('Producto agregado al plan de compras exitosamente', 'success');
        return redirect()->route('plan.index');

       }



    }

    public function deleteProduct($idProduct){

        


        $cotizacion = DB::table('plan_compras')
        ->select('cotizacion')
        ->where('id', '=', $idProduct)
        ->value('cotizacion');

        
        if($cotizacion){
        $archivo= public_path()."/cotizacion/".$cotizacion;

        if (file_exists($archivo)) {
            unlink($archivo);  
            }
        }

        DB::table('plan_compras')
        ->where('id', '=', $idProduct)
        ->delete();


        flash('Producto eliminado del plan de compras exitosamente', 'danger');
        return redirect()->back();
    }

    public function editProduct($idProduct){

        $periodo = DB::table('periodo')->first();
        $categorias = Especifico::all();
        $proveedores = DB::table('providers')->get();



        if($periodo->estado==1){



        $product = DB::table('plan_compras')
        ->where('id', '=', $idProduct)
        ->first();

        $nuevo = DB::table('providers')->where('telefono', '=', $product->nuevoproveedor)->first();


        return view('plandecompras.edit', compact('product', 'categorias', 'proveedores', 'nuevo'));

        }else{

            return redirect()->route('plandecompras.error');
        }

    }


    public function updateProduct(Request $request){

        $fecha = Carbon::now();

        $cotizacion = DB::table('plan_compras')
        ->select('cotizacion')
        ->where('id', '=', $request->input('idProduct'))
        ->value('cotizacion');

        

        $archivo= public_path()."/cotizacion/".$cotizacion;

        if (file_exists($archivo)) {
            unlink($archivo);  
        }

        DB::table('plan_compras')
        ->where('id', $request->input('idProduct'))
        ->update([
            'cotizacion'=>""
        ]);



        $file = $request->file('cotizacion');              
        $nombreOriginal =  'cotizacion'.$fecha.Auth::user()->id.$file->getClientOriginalName(); 
        //$newName = "cotizacion/".$nombreOriginal;
        $file->move(public_path('cotizacion/'), $nombreOriginal);

        DB::table('plan_compras')
        ->where('id', $request->input('idProduct'))
        ->update([
            'cantidad'=>$request->input('cantidad'),
            'nombre_producto'=>$request->input('nombre_producto'),
            'especificaciones'=>$request->input('especificaciones'),
            'precio_unitario'=>$request->input('precio'),
            'categoria' => $request->input('categoria'),
            'proveedor' => $request->input('proveedor'),
            'fecha' => $fecha,
            'nuevoproveedor' => $request->input('telefono'),
            'unidad' => $request->input('unidadmedida'),
            'total' => $request->input('total'),
            'cantidad_aprobada' =>$request->input('cantidad'),
 
            'cotizacion'=>$nombreOriginal
        ]);


        

        DB::table('providers')
        ->where('telefono', '=', $request->input('antiguo'))
        ->update([
            'nombre'=>$request->input('nuevoproveedor'),
            'telefono'=>$request->input('telefono')
        ]);

        

        flash('Producto editado exitosamente', 'info');
        return redirect()->route('plan.index');
    }

    public function historial(){
        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '!=', "Pendiente")
        ->get();

        $proveedores = DB::table('providers')->get();            
            
        
        return view('plandecompras.historial', compact('planDelUsuario', 'proveedores'));
        
    }

    public function historialGeneral(){

        $historialGeneral = DB::table('plan_compras')
        ->where('estado', '=', "Aprobado")
        ->orderBy('categoria', 'asc')
        ->get();


        //dd($hitorialGeneral);

        return view ('plandecompras.historialgeneral', compact('historialGeneral'));
    }


    public function solicitarExistencias($idProduct){

        $periodo = DB::table('periodo')->first();
        $proveedores = DB::table('providers')->get();


        if($periodo->estado==1){

        $product = Articulo::findOrFail($idProduct);    


        return view('plandecompras.solicitarexistencias', compact('product', 'proveedores'));

        }else{

            return redirect()->route('plandecompras.error');
        }
    }

    
    public function exportExcel(){

        $fecha = Carbon::now();


        Excel::create('plan de compras '.$fecha, function($excel) {

        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '=', "Pendiente")
        ->get();

        $nombreUsuario = Auth::user()->name;



            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $nombreUsuario) {
                $sheet->row(3, ['', 'Cuadro de plan de compras'
                ]);
                $sheet->row(4, ['', 'Usuario', $nombreUsuario]);

                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Especificaciones', 'Proveedor', 'Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {                    
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->especificaciones,$s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]); 
                }



            });

        })->export('xlsx');

    }

    public function exportPdf(){

        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '=', "Pendiente")
        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);

    }

    public function resumen(){

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'unidad','precio_unitario', DB::raw('SUM(cantidad) as cantidad'))
        ->where('estado', '=', "Pendiente")
        ->groupBy('nombre_producto', 'categoria','especificaciones', 'precio_unitario','unidad')
        ->get();

        $categorias = Especifico::all();

        
        
        return view('plandecompras.resumen', compact('planDelUsuario', 'categorias'));
    }



    public function resumenPdf(){

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'proveedor', 'precio_unitario', DB::raw('SUM(cantidad) as cantidad'))
        ->where('estado', '=', "Pendiente")
        ->groupBy('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'proveedor')
        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);



    }

    public function error(){
        return view('plandecompras.error');
    }

    public function confirmar(Request $request){

        $fecha = Carbon::now();

        $p = $request->input('precio');

        if ($p == "") {
            // code...
            $p = 0.0;
        }

        
       /* if ($request->hasFile('cotizacion')) {

            $file = $request->file('cotizacion');              
            $nombreOriginal = $file->getClientOriginalName(); 
            $file->move(public_path('cotizacion/'), $nombreOriginal);

        }
        else{
            echo "Debes subir documento";
        }
    */
        
        DB::table('plan_compras')->insert([
            'cantidad' => $request->input('cantidad'),
            'nombre_producto' => $request->input('nombre_producto'),
            'especificaciones' => $request->input('especificaciones'),
            'precio_unitario' => $p,
            'proveedor' => $request->input('proveedor'),
            //'cotizacion' => $nombreOriginal,
            'user_id' => $request->input('user_id'),
            'categoria' => $request->input('categoria'),
            'fecha' => $fecha,
            'estado' => $request->input('estado') 
        ]);

        flash('Producto agregado al plan de compras exitosamente', 'success');
        return redirect()->route('plan.index');

    }

    public function buscar(Request $request){

        $categoria = DB::table('especificos')->where('id', $request->input('categoria'))->first();

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'proveedor', 'precio_unitario', DB::raw('SUM(cantidad) as cantidad'))
        ->where('categoria', $categoria->titulo_especifico)
        ->where('estado', '=', "Pendiente")

        ->groupBy('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'proveedor')
        ->get();


        return view ('plandecompras.busqueda', compact('categoria', 'planDelUsuario'));
    }

    public function pdfCategoria($categoria){

        $categoria = DB::table('especificos')->where('id', $categoria)->first();

        
        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'proveedor', 'precio_unitario', DB::raw('SUM(cantidad) as cantidad'))
        ->where('categoria', $categoria->titulo_especifico)
        ->where('estado', '=', "Pendiente")

        ->groupBy('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'proveedor')
        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);
    }

    public function pdfUsuario($user_id){

        
        
        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', $user_id)
        ->where('estado', '=', "Pendiente")
        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);
    }

    public function excelCategoria($categoria){


        $fecha = Carbon::now()->format('d-m-Y');


        $categoria = DB::table('especificos')->where('id', $categoria)->first();

        //dd($categoria);

        Excel::create("Plan de Compras ".$categoria->titulo_especifico.$fecha, function($excel) use($categoria, $fecha) {

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'proveedor', 'precio_unitario', DB::raw('SUM(cantidad) as cantidad'))
        ->where('categoria', $categoria->titulo_especifico)
        ->where('estado', '=', "Pendiente")

        ->groupBy('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'proveedor')
        ->get();

        //dd($planDelUsuario);


            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $categoria, $fecha) {

                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Cuadro de plan de compras']);
                $sheet->row(4, ['', 'Categoría', $categoria->titulo_especifico]);
                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Categoría','Especificaciones', 'Proveedor', 'Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->categoria, $s->especificaciones, $s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]); 
                }



            });

        })->export('xlsx');
    }

    public function excelUsuario($user_id){


        $fecha = Carbon::now()->format('d-m-Y');

        //dd($categoria);

        Excel::create("Plan de Compras ".$categoria->titulo_especifico.$fecha, function($excel) use($user_id, $fecha) {

        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', $user_id)
        ->where('estado', '=', "Pendiente")
        ->get();

        //dd($planDelUsuario);


            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $fecha) {

                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Cuadro de plan de compras']);
                $sheet->row(4, ['', 'Categoría', $categoria->titulo_especifico]);
                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Categoría','Especificaciones', 'Proveedor', 'Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->categoria, $s->especificaciones, $s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]); 
                }



            });

        })->export('xlsx');
    }


    public function finalizar(){


        return view('plandecompras.finalizar');
    }

    public function finalizarconfirmado(){

        $estado = "Aprobado";
        $estado2 = "Pendiente";
        $cantidad = 0;


        DB::table('plan_compras')
        ->where('estado', "=", $estado)
        ->update([
            'estado'=>"Finalizado"
        ]);

        DB::table('plan_compras')
        ->where('estado', "=", $estado2)
        ->update([
            'estado'=>"Finalizado",

            'cantidad_aprobada'=>$cantidad,
            'total'=>$cantidad

        ]);        





        flash('Plan de compras reiniciado exitosamente', 'success');

        return redirect()->route('plandecompras.resumen');
    }

    
    public function descargarArchivo($cotizacion)
    {
        $archivo= public_path()."/cotizacion/".$cotizacion;
        if (file_exists($archivo)) {
            return Response::download($archivo);
        }
       
    }
    /*
    public function deleteArchivo($cotizacion)
    {   
        $archivo= public_path()."/cotizacion/".$cotizacion;
        
        if (file_exists($archivo)) {
            unlink($archivo);  
        }
        
        flash('Archivo eliminado del plan de compras exitosamente', 'danger');
        return redirect()->back();
    }

    */

    public function individual(){

        $planDelUsuario = DB::table('plan_compras')
        ->select('user_id','nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'cotizacion', 'id', 'proveedor', 'total', 'unidad', 'nuevoproveedor')
        ->where('estado', '=', "Pendiente")

        ->get();
        $proveedores = DB::table('providers')->get();  

        $categorias = Especifico::all();
        $users = User::all();

        return view('plandecompras.individual', compact('planDelUsuario', 'categorias', 'users', 'proveedores'));
    }

    public function excelIndividual(){

        $fecha = Carbon::now()->format('d-m-Y');

        $a = 7;

        $users = DB::table('users')
        ->get();


        $total = DB::table('plan_compras')
        ->select(DB::raw('SUM(total) as final'))
        ->where('estado', '=', "Pendiente")
        ->first();
       

        Excel::create("Plan de Compras Individual".$fecha, function($excel) use($fecha, $a, $total, $users) {

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'proveedor','user_id')
        ->where('estado', '=', "Pendiente")
        ->get();



            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $fecha, $a, $total, $users) {

                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Cuadro de plan de compras']);
               
                $sheet->row(6, [
                    'Usuario','Cantidad','Nombre del producto', 'Categoría','Especificaciones', 'Proveedor', 'Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {

                    $nombre = " ";


                    foreach($users as $u){

                        if ($s->user_id == $u->id) {
                            
                            $nombre = $u->name;

                        }

                    }




                       $sheet->row($index+7, [
                        $nombre, $s->cantidad, $s->nombre_producto, $s->categoria, $s->especificaciones,$s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]);

                    $a++; 
                }

                $sheet->row($a,[' ',' ', ' ', ' ', ' ',' ',' TOTAL', $total->final]);



            });

        })->export('xlsx');
    }


    public function pdfIndividual(){

        
        $fecha = Carbon::now()->format('d-m-Y');

        
        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'proveedor')
        ->where('estado', '=', "Pendiente")

        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);
    }

    public function buscarIndividual(Request $request){

        $categoria = DB::table('especificos')->where('id', $request->input('categoria'))->first();
        $proveedores = DB::table('providers')->get();   

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'cotizacion', 'id', 'proveedor', 'total', 'nuevoproveedor', 'unidad')
        ->where('estado', '=', "Pendiente")
        ->where('categoria', $categoria->titulo_especifico)
        ->get();


        return view ('plandecompras.busquedaIndividual', compact('categoria', 'planDelUsuario', 'proveedores'));
    }

    public function buscarIndividualUser(Request $request){

        $usuario = DB::table('users')->where('id', $request->input('usuario'))->first();
        $proveedores = DB::table('providers')->get();   

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'cotizacion', 'id', 'proveedor', 'total', 'nuevoproveedor', 'unidad', 'categoria')
        ->where('estado', '=', "Pendiente")
        ->where('user_id', $usuario->id)
        ->get();
        


        return view ('plandecompras.busquedaIndividualUser', compact('usuario', 'planDelUsuario', 'proveedores'));
    }




    public function pdfCategoriaInd($categoria){

        $categoria = DB::table('especificos')->where('id', $categoria)->first();

        
        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'proveedor')
        ->where('categoria', $categoria->titulo_especifico)
        ->where('estado', '=', "Pendiente")
        ->get();

        $view = \View::make('plandecompras.planpdf', ['solicitudes' => $planDelUsuario]);
                    $html = $view->render();

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(355.6, 216), true, 'UTF-8', false);
                    $pdf->SetTitle('Plan de Compras');
                    $pdf->SetHeaderData('', '', '', 'CENSALUD, Universidad de El Salvador', array(0,0,0), array(0,64,128));
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                    $pdf->AddPage('L');
                    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 8);
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
                    $pdf->setPrintFooter(true);

                    $pdf->SetFooterMargin(15);
                    $pdf->SetX(10);
                    $pdf->SetLeftMargin(10);
                    $pdf->SetRightMargin(10);
                    $pdf->SetTopMargin(17);


                    $pdf->setCellPaddings('1','3','1','3');
                    $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 64, 128));

                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                    $pdf->writeHTML($html, true, false, true, false, '');
                    $nombre = 'plandecompras '.$fecha.'.pdf';
                    $pdf->Output($nombre);
    }

    public function excelCategoriaInd($categoria){


        $fecha = Carbon::now()->format('d-m-Y');


        $categoria = DB::table('especificos')->where('id', $categoria)->first();


        Excel::create("Plan de Compras ".$categoria->titulo_especifico.$fecha, function($excel) use($categoria, $fecha) {

        $planDelUsuario = DB::table('plan_compras')
        ->select('nombre_producto', 'categoria','especificaciones', 'precio_unitario', 'cantidad', 'proveedor')
        ->where('categoria', $categoria->titulo_especifico)
        ->where('estado', '=', "Pendiente")
        ->get();




            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $categoria, $fecha) {

                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Cuadro de plan de compras']);
                $sheet->row(4, ['', 'Categoría', $categoria->titulo_especifico]);
                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Categoría','Especificaciones', 'Proveedor','Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->categoria, $s->especificaciones,$s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]); 
                }



            });

        })->export('xlsx');
    }


    public function finalizarCompra(Request $request){


        DB::table('plan_compras')
        ->where('id', '=', $request->input('idProduct'))
        ->update([
            'estado'=>"Aprobado",
            'cantidad_aprobada'=>$request->input('aprobada'),
            'total'=>$request->input('aprobada')*$request->precio
        ]);

        $cotizacion = DB::table('plan_compras')
        ->select('cotizacion')
        ->where('id', '=', $idProduct)
        ->value('cotizacion');

        
        if($cotizacion){
        $archivo= public_path()."/cotizacion/".$cotizacion;

        if (file_exists($archivo)) {
            unlink($archivo);  
            }
        }




        flash('Producto aprobado exitosamente', 'success');

        return redirect()->route('plandecompras.individual');
    }


    public function finalizarCompraFinal(Request $request){


        DB::table('plan_compras')
        ->where('id', '=', $request->input('idProduct'))
        ->update([
            'estado'=>"Finalizado",
            'cantidad_aprobada'=>$request->input('aprobada'),
            'total'=>$request->input('aprobada')*$request->precio
        ]);

        $cotizacion = DB::table('plan_compras')
        ->select('cotizacion')
        ->where('id', '=', $idProduct)
        ->value('cotizacion');

        
        if($cotizacion){
        $archivo= public_path()."/cotizacion/".$cotizacion;

        if (file_exists($archivo)) {
            unlink($archivo);  
            }
        }




        flash('Producto aprobado exitosamente', 'success');

        return redirect()->route('plandecompras.individual');
    }

    public function aprobar($idProduct){

         $product = DB::table('plan_compras')
        ->where('id', '=', $idProduct)
        ->first();

        $user = DB::table('users')
        ->where('id', '=', $product->user_id)
        ->first();

        return view('plandecompras.aprobar', compact('product', 'user'));
    }

    public function aprobarGeneral($a, $b, $c, $d, $e){

        $estado = 'Pendiente';  

        $planDelUsuario =  DB::table('plan_compras')
        ->where('nombre_producto', '=',$a)
        ->where('especificaciones', '=', $b)
        ->where('categoria', '=', $c)
        ->where('unidad', '=', $d)
        ->where('precio_unitario', '=', $e)
        ->where('estado', '=', $estado)

        ->get();

        $users = User::all();

        return view('plandecompras.aprobargeneral', compact('planDelUsuario', 'users', 'a', 'b', 'c', 'd', 'e'));
    }

    public function consultarGeneral($a){

      $articulo = DB::table('articulo')
      ->where('nombre_articulo','=',$a)
      ->first();


      //dd($producto);

      return view('plandecompras.consultarGeneral', compact('articulo'));
    }

    public function aprobarGeneralConfirmar($a, $b, $c, $d, $e){

        $estado = 'Pendiente'; 


        DB::table('plan_compras')
        ->where('nombre_producto', '=',$a)
        ->where('especificaciones', '=', $b)
        ->where('categoria', '=', $c)
        ->where('unidad', '=', $d)
        ->where('precio_unitario', '=', $e)
        ->where('estado', '=', $estado)
        ->update([
            'estado'=>"Aprobado"
            
        ]);



        
        flash('Productos aprobados exitosamente', 'success');

        return redirect()->route('plandecompras.resumen');

    }


    public function excelHistorial(){

        $fecha = Carbon::now()->format('d-m-Y');

        Excel::create("Plan de Compras ".$fecha, function($excel) use($fecha) {

        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '=', "Finalizado")
        ->get();

        $nombreUsuario = Auth::user()->name;




            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario, $fecha, $nombreUsuario) {

                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Historial de plan de compras']);
                $sheet->row(3, ['', 'Usuario', $nombreUsuario]);
                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Categoría','Especificaciones', 'Proveedor','Precio unitario', 'Costo total'
                ]);


                foreach($planDelUsuario as $index => $s) {
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->categoria, $s->especificaciones,$s->proveedor,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad
                    ]); 
                }



            });

        })->export('xlsx');


    }

    public function resumenExcel(){


        $fecha = Carbon::now()->format('d-m-Y');


        Excel::create('plan de compras '.$fecha, function($excel) use($fecha) {

        $categorias = DB::table('especificos')
        ->select('titulo_especifico')
        ->get();


        $total = DB::table('plan_compras')
        ->select(DB::raw('SUM(total) as final'))
        ->where('estado', '=', "Pendiente")
        ->first();

        $estado = 'Pendiente';  

        
        $plan = DB::select(
            'SELECT * FROM (
                SELECT categoria, SUM(total) FROM plan_compras WHERE estado = ? GROUP BY categoria) t1
            INNER join(SELECT * FROM plan_compras WHERE estado = ?) t2
            ON t1.categoria = t2.categoria',[$estado, $estado]
        );

        $c=7;
        $i=7;
        $a=0;


            $excel->sheet('plandecompras', function($sheet) use($plan, $fecha, $categorias, $c, $i, $total) {
                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Resumen de plan de compras general']);
                $sheet->row(6, [
                    'NOMBRE DEL BIEN', 'ESPECIFICACIONES TÉCNICAS', 'CANTIDAD','UNIDAD DE MEDIDA Y PRESENTACIÓN', 'PRECIO UNITARIO', 'TOTAL'
                ]);

                foreach($categorias as $index =>$s){

                    foreach($plan as $index2 => $s2){

                            
                            if($s->titulo_especifico == $s2->categoria){

                                $sheet->row($i,[$s2->categoria, ' ', ' ', ' ',' ', $s2->sum]);
                                
                                $sheet->row($c+1, [
                                $s2->nombre_producto, $s2->especificaciones,$s2->cantidad_aprobada, $s2->unidad,$s2->precio_unitario,$s2->total
                                ]);
                                $c++;
                                $a=$c; 
                            }   
                    }

                $i=$c+1;
                $c=$c+1;
                

                }

                $sheet->row($a+1,[' ', ' ', ' ', ' ',' TOTAL', $total->final]);

            });




        })->export('xlsx');

    }

    public function excelHistorialGeneral(){

        $fecha = Carbon::now()->format('d-m-Y');

        Excel::create("Plan de Compras General".$fecha, function($excel) use($fecha) {

      
        $categorias = DB::table('especificos')
        ->select('titulo_especifico')
        ->get();


        $total = DB::table('plan_compras')
        ->select(DB::raw('SUM(total) as final'))
        ->where('estado', '=', "Aprobado")
        ->first();

        $estado = 'Aprobado';  

        
        $plan = DB::select(
            'SELECT * FROM (
                SELECT categoria, SUM(total) FROM plan_compras WHERE estado != ? GROUP BY categoria) t1
            INNER join(SELECT * FROM plan_compras WHERE estado = ?) t2
            ON t1.categoria = t2.categoria',[$estado, $estado]
        );


        //dd($plan);


        $c=7;
        $i=7;
        $a=0;


            $excel->sheet('plandecompras', function($sheet) use($plan, $fecha, $categorias, $c, $i, $total) {
                $sheet->row(2, ['', 'Fecha', $fecha]);
                $sheet->row(3, ['', 'Historial de plan de compras general']);
                $sheet->row(6, [
                    'NOMBRE DEL BIEN', 'ESPECIFICACIONES TÉCNICAS', 'CANTIDAD','UNIDAD DE MEDIDA Y PRESENTACIÓN', 'PRECIO UNITARIO', 'TOTAL'
                ]);

                foreach($categorias as $index =>$s){

                    foreach($plan as $index2 => $s2){

                            
                            if($s->titulo_especifico == $s2->categoria){

                                $sheet->row($i,[$s2->categoria, ' ', ' ', ' ',' ', $s2->sum]);
                                
                                $sheet->row($c+1, [
                                $s2->nombre_producto, $s2->especificaciones,$s2->cantidad_aprobada, $s2->unidad,$s2->precio_unitario,$s2->total
                                ]);
                                $c++;
                                $a=$c; 
                            }   
                    }

                $i=$c+1;
                $c=$c+1;
                

                }

                $sheet->row($a+1,[' ', ' ', ' ', ' ',' TOTAL', $total->final]);

            });

        })->export('xlsx');


    }

}
