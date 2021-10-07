<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use sig\Models\TipoEquipo;
use sig\Models\Equipo;
use Crypt;
use DB;
use Datatables;
use sig\Models\Estados;
use Validator;
use sig\Models\BitacoraEquipo;
use Date;
use TCPDF;
use Maatwebsite\Excel\Facades\Excel;

use sig\Models\Archivo;
use Illuminate\Filesystem\Filesystem;
use File;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class EquipoController extends Controller
{
    public function tiposDeEquipos()
    {
    	$tiposEquipos = TipoEquipo::orderBy('nombre_tipo_equipo','ASC')->get();
    	$data['tiposEquipos'] = $tiposEquipos;
    	return view('equipo.tipoEquipo',$data);
    }

    public function nuevoTipoGet()
    {
    	return view('equipo.nuevoTipo');
    }

    public function nuevoTipoPost(Request $request)
    {
    	$this->validate($request,[
            
            'nombre' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/ |unique:tipo_equipo,nombre_tipo_equipo'
        ]);
        try {            
           

            $newTipoEquipo = new TipoEquipo();
            $newTipoEquipo->nombre_tipo_equipo = $request->nombre;
            $newTipoEquipo->save();          
            

            flash('guardado exitosamente', 'success');
            return redirect()->route('equipo.lista.tipos');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function editarTipoEquipoGet($idTipo)
    {
    	$idtipo = Crypt::decrypt($idTipo);
    	$tipoEquipo = TipoEquipo::where('id_tipo_equipo',$idtipo)->first();
    	$data['tipoEquipo'] = $tipoEquipo;
    	return view('equipo.editarTipo',$data);
    }

    public function editarTipoEquipoPost(Request $request)
    {
    	$this->validate($request,[
            
            'nombre' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/ |unique:tipo_equipo,nombre_tipo_equipo'
        ]);
        try {            
            DB::beginTransaction();

            $tipoEquipo = TipoEquipo::where('id_tipo_equipo',$request->idtipo)->first();
            $tipoEquipo->nombre_tipo_equipo = $request->nombre;
            $tipoEquipo->save();          
            

            flash('guardado exitosamente', 'success');
            DB::commit();
            return redirect()->route('equipo.lista.tipos');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function eliminarTipoEquipo(Request $request)
    {	DB::beginTransaction();
    	try 
    	{
    		$equiposAsociados = Equipo::where('id_tipo_equipo',$request->idtipo)->count();
    		if($equiposAsociados>0)
    		{
    			return response()->json(['status' => 400, 'message' => 'El tipo de equipo tiene equipos asociados']);
    		}
    		else
    		{
    			TipoEquipo::where('id_tipo_equipo',$request->idtipo)->delete();
    		}   		
    		
    	} catch (Exception $e) {
    		DB::rollback();
    		return response()->json(['status' => 400, 'message' => 'Codigo: '.$e->getCode().' Mensaje: '.$e->getMessage()]);    		
    	} 
    	DB::commit();  
    	return response()->json(['status' => 200, 'message' => 'exito']); 	 
    }

    public function lista()
    {
    	$tipos = TipoEquipo::all();
    	$estados = Estados::all();

    	$data['tipos']= $tipos;
    	$data['estados'] = $estados;

    	return view('equipo.lista',$data);
    }

    public function getListaDeEquipos(Request $request)
    {
    	$equipos = DB::table('equipo as eq')
    		->join('tipo_equipo as te','eq.id_tipo_equipo','=','te.id_tipo_equipo')
    		->join('estado as es','eq.idestado','=','es.idestado')
    		->select('eq.*','te.nombre_tipo_equipo as tipo','es.estado as status')
	    	->where(function ($query) use ($request){
				if($request->has('ftipo'))
				{
	        		$query->where('eq.id_tipo_equipo','=',$request->get('ftipo'));
	        	}
	        	if($request->has('festado'))
				{
	        		$query->where('eq.idestado','=',$request->get('festado'));
	        	}
                if($request->has('num_inventario'))
                {
                    $query->where('eq.numero_inventario','like','%'.$request->get('num_inventario').'%');
                }
                if($request->has('num_serie'))
                {
                    $query->where('eq.numero_serie','like','%'.$request->get('num_serie').'%');
                }
			});       
        
        
        return Datatables::of($equipos)
        	->addColumn('opciones',function($dt){	
				
				return '<a title="editar equipo" onClick="mdlEditarEquipo(\''.$dt->id_equipo.'\');" class="btn btn-xs btn-primary btn-perspective"><i class="fa fa-pencil" aria-hidden="true"></i></a>'.
				'<a title="detalles" href="'.route('equipo.detalles',['idEquipo' => Crypt::encrypt($dt->id_equipo)]).'" class="btn btn-xs btn-primary btn-perspective"><i class="fa fa-eye" aria-hidden="true"></i></a>'.
                '<a title="eliminar" onClick="return fcnEliminar(\''.$dt->id_equipo.'\');" class="btn btn-xs btn-danger btn-perspective"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				
			}) 
        	->make(true);
        
    }

    public function insertarEquipo(Request $request)
    {
    	$v = Validator::make($request->all(),[
            'tipoEquipo'=>'required', 
            'numInventario'=>'required',
            'especifico'=>'required', 
            'numSerie'=>'required', 
            'marca'=>'required',
            'modelo'=>'required', 
            'descripcion'=>'required', 
            'procedencia' =>'required',
            'estado'=>'required',
            'responsable' => 'required',
            'ubicacion'=>'required',
            'fecha_adquisicion'=>'required'        
            
        ]);

        $v->setAttributeNames([ 
            'tipoEquipo'=>'TIPO DE EQUIPO', 
            'numInventario'=>'NÚMERO DE INVENTARIO', 
            'especifico'=>'ESPECIFICO',
            'numSerie'=>'NÚMERO DE SERIE',
            'marca'=>'MARCA', 
            'modelo'=>'MODELO', 
            'descripcion'=>'DESCRIPCIÓN', 
            'procedencia' =>'PROCEDENCIA',
            'estado'=>'ESTADO',
            'responsable' => 'RESPONSABLE',
            'ubicacion'=>'UBICACIÓN',
            'fecha_adquisicion'=>'FECHA DE ADQUISICIÓN'          

        ]);
       
        if ($v->fails())
        { 
            $msg = "<ul class='text-warning'>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return $msg;
        }
        if($request->procedencia == 'compra' && $request->precio=='')
        {
            $msg = "<ul class='text-warning'><li>DEBE INGRESAR EL PRECIO</li></ul>";           
            return $msg;
        }
        DB::beginTransaction();
		try 
		{ 	
            if($request->id_equipo!='')
            {
                $oldEquipo = Equipo::where('id_equipo',$request->id_equipo)->first();

                if($oldEquipo)
                {
                    /*se inserta en la bitacora de equipo si hay cambios en responsable o estado*/
                    if($oldEquipo->responsable!=$request->responsable|| $oldEquipo->idestado != $request->estado)
                    {
                        $bitacora = new BitacoraEquipo();
                        $bitacora->id_equipo = $oldEquipo->id_equipo;
                        $bitacora->idestado = $request->estado;
                        $bitacora->responsable = $request->responsable;
                        $bitacora->save();
                    }                

                    /*se asignan los nuevos valores*/
                    $oldEquipo->responsable = $request->responsable;
                    $oldEquipo->id_tipo_equipo = $request->tipoEquipo;
                    $oldEquipo->numero_inventario = $request->numInventario;
                    $oldEquipo->especifico = $request->especifico;
                    $oldEquipo->numero_serie = $request->numSerie;
                    $oldEquipo->descripcion = $request->descripcion;
                    $oldEquipo->idestado = $request->estado;
                    $oldEquipo->observacion = $request->observacion;
                    $oldEquipo->ubicacion = $request->ubicacion;
                    $oldEquipo->marca = $request->marca;
                    $oldEquipo->modelo = $request->modelo;
                    $oldEquipo->procedencia = $request->procedencia;
                    $oldEquipo->fecha_adquisicion = $request->fecha_adquisicion;
                    $oldEquipo->precio = $request->precio;
                    
                    $oldEquipo->save();

                }
            }
            else
            {
                $equipo = new Equipo();
                $equipo->responsable = $request->responsable;
                $equipo->id_tipo_equipo = $request->tipoEquipo;
                $equipo->especifico = $request->especifico;
                $equipo->numero_inventario = $request->numInventario;
                $equipo->numero_serie = $request->numSerie;
                $equipo->descripcion = $request->descripcion;
                $equipo->idestado = $request->estado;
                $equipo->observacion = $request->observacion;
                $equipo->ubicacion = $request->ubicacion;
                $equipo->marca = $request->marca;
                $equipo->modelo = $request->modelo;
                $equipo->procedencia = $request->procedencia;
                $equipo->fecha_adquisicion = $request->fecha_adquisicion;
                $equipo->precio = $request->precio;
                
                $equipo->save();

                /*se inserta en la bitacora de equipo*/
                $bitacora = new BitacoraEquipo();
                $bitacora->id_equipo = $equipo->id_equipo;
                $bitacora->idestado = $equipo->idestado;
                $bitacora->responsable = $equipo->responsable;
                $bitacora->save();
            }
			
		} /*fin del try*/
		catch(PDOException $eX)
		{
	        DB::rollback();
	        return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
	    }

	 	DB::commit();

    	return response()->json(['state' => 'success']);
    }

    public function getEquipoToEditar(Request $request)
    {
        $equipo = Equipo::where('id_equipo',$request->param)->first();
        return $equipo;
    }

    public function detallesDeEquipo($idEquipo)
    {
    	$idequipo = Crypt::decrypt($idEquipo); 
    	$equipo = Equipo::where('id_equipo',$idequipo)->first();

    	$data['equipo'] = $equipo;

    	return view('equipo.detalles',$data);
    }

     public function reporteDeEquipos()
    { 
        try{
            
            $equipos = Equipo::select('numero_inventario','responsable','id_tipo_equipo','idestado')->orderBy('id_tipo_equipo','ASC')->with('tipo')->with('status')->get();
                                                
            
            $date = new Date();
            $fecha = $date->format('l, j \d\e F \d\e Y');
            
            $nombre = 'equipos_'.$date->format('Y-m-d').'.pdf';
           
            $data['fecha'] = $fecha;
            $data['equipos'] = $equipos;
            
            //TCPDF
            $view = \View::make('equipo.reporte',$data);
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(279.4, 216), true, 'UTF-8', false);
            $pdf->SetTitle('Equipos');
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

    public function resumenDeEquipos(){
        try{
            $tipos = TipoEquipo::select('*')->get();
           
            $estados = Estados::orderBy('estado','ASC')->get();
            foreach ($tipos as $tipo) {
                $var_estado = array();
                foreach($estados as $estado)
                {
                    $var_estado[] = Equipo::where('idestado',$estado->idestado)
                        ->where('id_tipo_equipo',$tipo->id_tipo_equipo)->count();
                }
                $tipo->cantidad_estado = $var_estado;
            }                         
            
            $date = new Date();
            $fecha = $date->format('l, j \d\e F \d\e Y');
            
            $nombre = 'resumen_equipos_'.$date->format('Y-m-d').'.pdf';

            $data['tipos'] = $tipos;
            $data['fecha'] = $fecha;
           
            $data['estados'] = $estados;

            //TCPDF
            $view = \View::make('equipo.resumen',$data);
            $html = $view->render();

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(279.4, 216), true, 'UTF-8', false);
            $pdf->SetTitle('Equipos');
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

    public function eliminarEquipo(Request $request){
        DB::beginTransaction();
        try 
        {
            $equipo = Equipo::where('id_equipo',$request->param)->first();

            $bitacoras = BitacoraEquipo::where('id_equipo',$equipo->id_equipo)->get();
            foreach ($bitacoras as $bitacora) {
                $bitacora->delete();
            }

            $equipo->delete();
        } /*fin del try*/
        catch(PDOException $ex)
        {
            DB::rollback();
           return response()->json(['status' => 400]);
        }
        DB::commit();        
        return response()->json(['status' => 200]);
    }

    public function exportarAExcel(Request $request){
        Excel::create('Equipos', function($excel) {

            $equipos = DB::table('inventario.equipo as eq')
                ->join('inventario.estado as es','eq.idestado','=','es.idestado')
                ->join('tipo_equipo as te','eq.id_tipo_equipo','=','te.id_tipo_equipo')   
                ->select('te.nombre_tipo_equipo as tipo','eq.id_equipo','eq.numero_inventario','eq.especifico','eq.descripcion','eq.marca','eq.modelo','eq.numero_serie','eq.fecha_adquisicion','eq.precio','eq.idestado','es.estado','eq.procedencia')
                ->orderBy('idestado')->get();

           
            $excel->sheet('Equipos', function($sheet) use($equipos) {
                $sheet->row(1, [
                    '', '', '', '', '','','','','','','FECHA DE','VALORES'
                ]);
                $sheet->row(2, [
                    'TIPO','CUENTA', 'UNIDAD', 'CLASE', 'CORREL.', 'ESPECIF.','DESCRIPCION DEL BIEN','MARCA','MODELO','SERIE','ADQUISIC.','DOLARES','ESTADO','PROCEDENCIA'
                ]);
                
                foreach($equipos as $index => $equipo) {
                    $arreglo = explode("-", $equipo->numero_inventario);
                    if(count($arreglo)>=4)
                    {
                        $arreglo3 = explode(" ", $arreglo[3]);
                    }
                    elseif(count($arreglo)==3)
                    {
                       $arreglo3[0]=""; 
                    }
                    elseif (count($arreglo)==2) {
                        $arreglo3[0]=""; 
                        $arreglo[2]="";
                    }
                    elseif (count($arreglo)==1){
                        $arreglo3[0]=""; 
                        $arreglo[2]="";
                        $arreglo[1]="";
                    }
                    $sheet->row($index+3, [
                        $equipo->tipo, $arreglo[0],$arreglo[1],$arreglo[2],$arreglo3[0], $equipo->especifico, $equipo->descripcion, $equipo->marca, $equipo->modelo, $equipo->numero_serie, $equipo->fecha_adquisicion, $equipo->precio, $equipo->estado, $equipo->procedencia
                    ]); 
                }

            });

        })->export('xlsx');
    }

    /******************************************************/
    /*Seccion para archivos de equipos*/
    public function archivosIndex(){        

        return view('equipo.archivos');    
    }

    public function getDatatableM(Request $request,$fcategoria)
    {        
        $archivosM = Archivo::where('categoria',$fcategoria)
        ->where(function ($query) use ($request) {
           
            if ($request->has('ftitulo')) 
            {
              $query->where('titulo_archivo','LIKE','%'.$request->get('ftitulo').'%');
            }
            if ($request->has('ffecha')) 
            {
              $query->where('fecha_subida','LIKE','%'.$request->get('ffecha').'%');
            }               
        
        })->select('*');

        return Datatables::of($archivosM)
            ->addColumn('descargar',function($dt){
                return '<a href="'.route('ver.documento',['urlDocumento' => Crypt::encrypt($dt->url_archivo),'tipoArchivo'=>Crypt::encrypt($dt->tipo_archivo)]).'" class="btn btn-xs btn btn-primary btn-perspective" title="ver o descargar" target="_blanck"><i 
                    class="fa fa-download"></i></a>'.
                    '&nbsp;&nbsp;<a class="btn btn-xs btn btn-danger btn-perspective" title="eliminar" onclick="eliminarArchivo(\''.Crypt::encrypt($dt->id).'\',\''.$dt->categoria.'\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';              
            })
            ->addIndexColumn('numero')
            ->make(true);
     
    }

    public function subirArchivosM(Request $request){
        DB::beginTransaction();
        try{
            $dir = getcwd(); // directorio actual
            $urlPrincipal = explode( '/public', $dir) ;
            $categoria = $request->categoria;
            
            if($categoria=='M1')
            {
                $listArchivos = $request->file('fileM1'); 
                $path = $urlPrincipal[0].'/archivos/M1';
            }
            elseif($categoria=='M2')
            {
                $listArchivos = $request->file('fileM2'); 
                $path = $urlPrincipal[0].'/archivos/M2';
            }
            elseif($categoria=='M3')
            {
                $listArchivos = $request->file('fileM3'); 
                $path = $urlPrincipal[0].'/archivos/M3';
            }
            elseif($categoria=='M4')
            {
                $listArchivos = $request->file('fileM4'); 
                $path = $urlPrincipal[0].'/archivos/M4';
            }
            elseif($categoria=='M5')
            {
                $listArchivos = $request->file('fileM5'); 
                $path = $urlPrincipal[0].'/archivos/M5';
            }
           
            $filesystem= new Filesystem();
            if(count($listArchivos)>0 && !empty($listArchivos) && !is_null($listArchivos[0]))
            {
                $carpeta=$path;
                if(!$filesystem->exists($path))
                {                    
                    File::makeDirectory($carpeta, 0777, true, true);
                }
                                     
                //for($a=0;$a<count($listArchivos);$a++)
                foreach ($listArchivos as $ar)
                {  //dd(count($listArchivos));                  
                    $name= $ar->getClientOriginalName(); 
                    $type = $ar->getMimeType();
                    $cuenta=0;
                    $cuenta = Archivo::where('titulo_archivo',$name)->where('categoria',$categoria)->count();
                    if($cuenta<1)
                    {
                        $ar->move($carpeta,$name);

                        $archivo = new Archivo();
                        $archivo->titulo_archivo = $name;
                        $archivo->url_archivo = $carpeta.'/'.$name;
                        $archivo->tipo_archivo = $type;
                        $archivo->fecha_subida = date('Y-m-d');
                        $archivo->categoria = $categoria;
                        $archivo->save();
                    }
                    else
                    {
                        $ar->move($carpeta,$name);//el archivo es reemplazado
                    }                   
                }                               
            }
            else
            {
                return "Debe seleccionar almenos un archivo a subir!"; 
            }
        }
        catch(PDOException $e)
        {
            DB::rollback();
            return response()->json(['status' => 400, 'message' => "<ul class='text-warning'><li>OCURRIÓ UN ERROR</li></ul>"],200);   
        }
        DB::commit(); 
        return response()->json(['status' => 200, 'message' => "Exito"],200);
        
    }//fin de function archivosM1

    public function elminarArchivo(Request $request){    
        $v = Validator::make($request->all(),[          
            'txtArchivo'=>'required',
            'catego' => 'required'
                ]);

        $v->setAttributeNames([
          'txtArchivo'=>'id del archivo',
          'catego'=> 'categoria'
        ]);
        if ($v->fails())
        {
            $msg = "<ul class='text-warning'>";
            foreach ($v->messages()->all() as $err) {
                $msg .= "<li>$err</li>";
            }
            $msg .= "</ul>";
            return $msg;
        }
        DB::beginTransaction();
        try
        {
            $id_archivo = Crypt::decrypt($request->txtArchivo); 
            $archivo = Archivo::where('id',$id_archivo)->first();        

            //$dir = getcwd(); // directorio actual
            $dir = public_path();  
            $urlPrincipal = explode( '/public', $dir) ;
            $categoria = $request->catego;

            $path = $urlPrincipal[0].'/archivos/'.$categoria;
           
            $urlToEliminar = $path.'/'.$archivo->titulo_archivo;
            //dd($urlToEliminar);
            //Storage::delete($urlToEliminar);/*se elimina el archivo fisico*/
            File::delete($urlToEliminar);
            $archivo->delete();/*se elimina el registro en la base de datos*/
            
        }
        catch(PDOException $e)
        {
            DB::rollback();
            throw $e;
            return $e->getMessage();  
        }
        DB::commit(); 
        return response()->json(['state' => 'success']);
    }
}
