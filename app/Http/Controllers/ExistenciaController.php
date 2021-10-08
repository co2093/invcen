<?php
namespace sig\Http\Controllers;
use sig\Models\Articulo;
use Illuminate\Http\Request;
use sig\Http\Requests;
use sig\Models\Ingreso;
use sig\Models\Descargo;
use sig\Models\Especifico;

use Date;
use PDF;
use DB;
use Exception;
class ExistenciaController extends Controller
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
		$articulos = Articulo::orderBy('id_especifico','asc')->orderBy('created_at','asc')->get();
		return view('existencia.index',['articulos'=>$articulos]);
         }catch (Exception $ex){
             return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
         }
	}

	public function ofertaDemanda(){

        try{
        $ofertaDemanda = DB::select('select * from oferta_demanda');
        return view('existencia.ofertaDemanda',['ofertaDemanda'=>$ofertaDemanda]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }


    public function show($id){

    }

    //Muestra formulario para editar existencias
    public function edit($codigoArticulo)
    {
        try {
            $articulo = Articulo::findOrFail($codigoArticulo);
          
            return view('existencia.edit', ['articulo' => $articulo]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }


    //Actualiza las existencias
    public function update(Request $request, $codigoArticulo)
    {

        try {
            $articulo = Articulo::FindOrFail($codigoArticulo);
            if ($articulo) {


                $articulo->update([
                    'existencia' => $request->input('existenciaNueva')
                ]);

                /*$articulo->save();
                /*$articulo->update([
                    'nombre_articulo' => $request->input('nombre'),
                    'id_unidad_medida' => $request->input('unidad'),
                    'id_especifico' => $request->input('especifico')
                ]);*/
                flash('Existencia actualizada exitosamente', 'success');
                return redirect()->route('existencia.index');

            } else {
                flash('Error a la actualizar existencia', 'danger');
                return redirect()->route('existencia.edit');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }
    
}