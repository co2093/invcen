<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Http\Requests;
use DB;
use sig\Models\Articulo;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;

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
        return redirect()->route('plan.index');

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

    public function historial(){
        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '!=', "Pendiente")
        ->get();
        
        return view('plandecompras.historial', compact('planDelUsuario'));
        
    }


    public function solicitarExistencias($idProduct){


        $product = DB::table('articulo')
        ->where('codigo_articulo', '=', $idProduct)
        ->first();

        return view('plandecompras.solicitarexistencias', compact('product'));
    }

    
    public function exportExcel(){

        Excel::create('plandecompras', function($excel) {

        $planDelUsuario = DB::table('plan_compras')
        ->where('user_id', '=', Auth::user()->id)
        ->where('estado', '=', "Pendiente")
        ->get();


            $excel->sheet('plandecompras', function($sheet) use($planDelUsuario) {
                $sheet->row(3, ['', 'Cuadro de plan de compras'
                ]);
                $sheet->row(6, [
                    'Cantidad','Nombre del producto', 'Especificaciones', 'Precio unitario', 'Costo total', 'Proveedor','Cotización'
                ]);


                foreach($planDelUsuario as $index => $s) {                    
                       $sheet->row($index+7, [
                        $s->cantidad, $s->nombre_producto, $s->especificaciones,round($s->precio_unitario,2), round($s->precio_unitario,2)*$s->cantidad,$s->proveedor,$s->cotizacion
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
                    $nombre = 'plandecompras.pdf';
                    $pdf->Output($nombre);

    }





}
