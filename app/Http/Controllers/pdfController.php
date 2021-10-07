<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;

use Session;

use PDF;
use sig\pdf\ClassPdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Encryption;

use Date;
use DB;
use sig\Models\Equipo;

use Crypt;
use File;
use Response;

class pdfController extends Controller
{
    public function reporteDeEquipos(){	 


    	try{
    		$date = new Date();
            $nombre = 'equipos_'.$date->format('Y-m-d').'.pdf';
            //$equipos = Equipo::all();
            $equipos = DB::table('inventario.equipo as eq')
                ->join('inventario.estado as es','eq.idestado','=','es.idestado')
                ->join('inventario.tipo_equipo as te','eq.id_tipo_equipo','=','te.id_tipo_equipo')
                ->select('eq.id_equipo','te.nombre_tipo_equipo as tipo','eq.numero_inventario','eq.responsable','es.estado as status','eq.idestado')->orderBy('eq.idestado')->get();
                                                           
            
            $pdf = new ClassPdf();		   
		    $pdf->SetTitle('Equipos');
              		      
		    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);          
		    $pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
		    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);    
		    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		    $pdf->setFontSubsetting(true);

		    $pdf->AddPage('P');
		    $pdf->SetFont('Times', '', 10);
		    
		    $tabla='<table border=".5">
			  <thead>
			    <tr>
			        <th ><strong>TIPO</strong></th>
			        <th ><strong>NÚMERO INVENTARIO</strong></th>
			        <th ><strong>RESPONSABLE</strong></th>
			        <th ><strong>ESTADO</strong></th>
			    </tr>
			  </thead>
			  <tbody>			    
			  </tbody>  
			</table>';		    
			$pdf->writeHTML($tabla, false, false, true, false, '');

			foreach ($equipos as $equipo) {
		      $tabla = '<table border=".5">
		        <tbody>
		        <tr align="left" >
		          <td>'.$equipo->tipo.'</td>
		          <td>'.$equipo->numero_inventario.'</td>
		          <td>'.$equipo->responsable.'</td> 
		          <td>'.$equipo->status.'</td>          
		        </tr>
		      </tbody></table>';
		      $pdf->writeHTML($tabla, false, false, true, false, '');
		    }
		    
		    $pdf->Output($nombre);

        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }		
  }

  public function pdfArchivosEquipos($urlDocumento,$tipoDoc){    
       
    if($urlDocumento!="")
    {

      $urlDocumento=Crypt::decrypt($urlDocumento);   
      $td=Crypt::decrypt($tipoDoc);
      $tipoArchivo = trim($td);
      
      $info = pathinfo($urlDocumento);
      $filename =  basename($urlDocumento,'.'.$info['extension']);
      //dd($file_name);
      if($tipoArchivo=='application/pdf')
      {    
        if (File::isFile($urlDocumento))
        {
          try 
          {
            $file = File::get($urlDocumento);
            $response = Response::make($file, 200);         
            $response->header('Content-Type', 'application/pdf');
            $response->header('Content-Disposition', 'inline; filename="Documento - '.$filename.'.pdf"');
            return $response;           
          } 
          catch (Exception $e) 
          {                                
            return Response::download(trim($urlDocumento));
          }
        }else{
          return back();
        }
      }
      else if($tipoArchivo=='image/png' or $tipoArchivo==='image/jpeg')
      {
        if (File::isFile($urlDocumento))
        {
          $file = File::get($urlDocumento);
          $response = Response::make($file, 200);
          // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
           $content_types = [
                'image/png', // png etc
                'image/jpeg', // jpeg
                  ];
          $response->header('Content-Type', $content_types);
          $response->header('Content-Disposition', 'inline; filename="Documento - '.$filename.'.jpeg"');
          return $response;           
        }
        else
        {
          //REToRNA A LA VISTA SI NO EXISTE ESE ARCHIVO
          return back();
        }
      }
      else
      {
        if (File::isFile($urlDocumento))
        {  
          return Response::download(trim($urlDocumento));
        }
      }

    }
  }
}
