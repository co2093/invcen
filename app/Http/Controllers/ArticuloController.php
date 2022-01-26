<?php

namespace sig\Http\Controllers;
use Illuminate\Http\Request;
use sig\Http\Requests;
use DB;
use Session;
use sig\Models\Articulo;
use sig\Models\UnidadMedida;
use sig\Models\Presentacion;
use sig\Models\GenerarCodigo;
use sig\Models\Especifico;
use Exception;
use Auth;
use Datatables;
use sig\Models\ExistenciaReactivo;
use sig\Models\MenosReactivo;

class ArticuloController extends Controller
{
    public function __construct()
    {
        try {
            $this->middleware('auth');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }


    public function index(Request $request){
                
       /* if($request->ajax())
        {
            if($request->category_filter)
            {
                //consulta para mostrar articulos de una categoría seleccionada
                $data = DB::table('articulo')
                ->join('especificos', 'especificos.id', '=', 'articulo.id_especifico')
                ->join('unidad_medida', 'unidad_medida.id_unidad_medida', '=', 'articulo.id_unidad_medida')
                ->select('especificos.titulo_especifico', 'articulo.codigo_articulo', 'articulo.nombre_articulo','unidad_medida.nombre_unidadmedida')
                ->where('articulo.id_especifico', $request->category_filter)
                ->get();
            }
            else
            {
                //si no se selecciona una categoría 
                $data = DB::table('articulo')
                ->join('especificos', 'especificos.id', '=', 'articulo.id_especifico')
                ->join('unidad_medida', 'unidad_medida.id_unidad_medida', '=', 'articulo.id_unidad_medida')
                ->select('especificos.titulo_especifico', 'articulo.codigo_articulo', 'articulo.nombre_articulo','unidad_medida.nombre_unidadmedida')
                ->get();
            }
            return datatables()->of($data)->make(true);
        }else{
            //return ("No ajax found");
        }

            $especificos = DB::table('especificos')
                            ->select("*")
                            ->get();
 
 
            return view('articulos.index', compact('especificos'));*/


            try 
            {           
                $articulos = Articulo::orderBy('id_especifico','asc')->get();         
                
                return view('articulos.index', ['articulos' => $articulos]);
            }catch (Exception $ex){
                return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
            }
        
    }


    public function create()
    {
        try {
            $unidades = UnidadMedida::orderBy('nombre_unidadmedida', 'asc')->get();
            $especificos = Especifico::orderBy('id', 'asc')->get();
            return view('articulos.create', ['unidades' => $unidades, 'especificos' => $especificos]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[

            'unidad' => 'required | integer|min:1',
            'especifico' => 'required |integer | digits:5|min:1| exists:especificos,id',
            'nombre' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/ |unique:articulo,nombre_articulo'
        ]);
        try {
            $articulos = Articulo::where([
                ['id_especifico', '=', $request->input('especifico')]
            ])->get();
            $codigo = GenerarCodigo::getCodigo($articulos, $request->input('especifico'), $request->input('nombre'));

            $newarticulo = new Articulo();
            $newarticulo->codigo_articulo = $codigo;
            $newarticulo->nombre_articulo =  $request->input('nombre');
            $newarticulo->id_unidad_medida = $request->input('unidad');
            $newarticulo->id_especifico = $request->input('especifico');
            //
            if($request->es_reactivo==1)
            {
                $newarticulo->es_reactivo = 'S';
                $newarticulo->formula = $request->formula;
            }
            
            $newarticulo->save();
           
            flash('Producto guardado exitosamente', 'success');
            return redirect()->route('articulo.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function show($codigoArticulo)
    {
        try {
            $articulo = Articulo::findOrFail($codigoArticulo);
            return view('articulos.details', ['articulo' => $articulo]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function edit($codigoArticulo)
    {
        try {
            $articulo = Articulo::findOrFail($codigoArticulo);
            $especificos = Especifico::orderBy('id', 'asc')->get();
            $unidades = UnidadMedida::orderBy('nombre_unidadmedida', 'asc')->get();
            return view('articulos.edit', ['articulo' => $articulo, 'unidades' => $unidades, 'especificos' => $especificos]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function update(Request $request, $codigoArticulo)
    {
        $this->validate($request,[
            'nombre'=>'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/ |unique:articulo,nombre_articulo,'.$codigoArticulo.',codigo_articulo',
            'unidad' => 'required | integer |min:1',
            'especifico' => 'required |digits:5 |min:1| exists:especificos,id'
        ]);
        try {
            $articulo = Articulo::FindOrFail($codigoArticulo);
            if ($articulo) {

                $articulo->nombre_articulo = $request->input('nombre');
                $articulo->id_unidad_medida = $request->input('unidad');
                $articulo->id_especifico = $request->input('especifico');
                if($request->es_reactivo=='1')
                {
                    $articulo->es_reactivo = 'S';
                    $articulo->formula = $request->formula;
                }
                else
                {
                    $articulo->es_reactivo = 'N';
                    $articulo->formula = "";
                }
                $articulo->save();
                /*$articulo->update([
                    'nombre_articulo' => $request->input('nombre'),
                    'id_unidad_medida' => $request->input('unidad'),
                    'id_especifico' => $request->input('especifico')
                ]);*/
                flash('Producto actualizado exitosamente', 'success');
                return redirect()->route('articulo.index');

            } else {
                flash('Error a la actualizar producto', 'danger');
                return redirect()->route('articulo.edit');
            }
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }

    }

    public function delete($codigoArticulo){
        try {
            $articulo = Articulo::findOrFail($codigoArticulo);
            return view('articulos.delete', ['articulo' => $articulo]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function destroy($codigoArticulo)
    {
        try {
            $articulo = Articulo::findOrFail($codigoArticulo);
            if($articulo->transacciones->count() > 0){
                flash('Error al eliminar producto, tiene tiene transacciones asociadas', 'danger');
                return redirect()->back();
            }elseif ($articulo->existencia > 0 && precio >= 0.00){
                flash('Error al eliminar producto, hay articulos en existencia', 'danger');
                return redirect()->back();
            }else{
                flash('Producto eliminado exitosamente', 'success');
                $articulo->delete();
                return redirect()->route('articulo.index');
            }

        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function getExistenciaReactivos(Request $request)
    {
        //$asignado = MenosReactivo::where('id_detalle_requisicion',$request->detalle)->pluck('fecha_expira');
        $existencias = ExistenciaReactivo::where('codigo_articulo',$request->articulo)
                    ->where('cantidad','>',0)
                    //->whereNotIn('fecha_expira',$asignado)
                    ->select('fecha_expira', DB::raw('sum(cantidad) as total'))
                    ->orderBy('fecha_expira','ASC')
                    ->groupBy('fecha_expira');

        return Datatables::of($existencias)
            ->addColumn('restante',function($dt)use($request){   
                $asignado = MenosReactivo::where('codigo_articulo',$request->articulo)
                    ->where('fecha_expira',$dt->fecha_expira)
                    ->where('id_detalle_requisicion','!=',$request->detalle)
                    ->select(DB::raw('sum(cantidad) as total'))->get();
               
                return $dt->total - $asignado[0]->total;
                
            })
            ->make(true); 
    }

    public function getReactivosAsignados(Request $request)
    {
        $reactivosAsignados = MenosReactivo::where('id_detalle_requisicion',$request->param)->get();

        if($reactivosAsignados)
        {
            foreach ($reactivosAsignados as $ra) {
                $sinAsignar = ExistenciaReactivo::where('codigo_articulo',$request->articulo)
                    ->where('fecha_expira','=',$ra->fecha_expira)
                    ->select(DB::raw('sum(cantidad) as total'))->get();

                $asignado = MenosReactivo::where('codigo_articulo',$request->articulo)
                    ->where('fecha_expira',$ra->fecha_expira)
                    ->where('id_detalle_requisicion','!=',$request->param)
                    ->select(DB::raw('sum(cantidad) as total'))->get();

                $ra->quedan = $sinAsignar[0]->total - $asignado[0]->total;
            }
        }            
        
        return $reactivosAsignados;
    }

    public function calculoMonto($codigoArticulo){
        
        $monto = DB::select("sum(montoTotal) as MT"
            (DB::raw("SELECT pre_unit_ant, exis_ant, cantidad, pre_unit, sum((cantidad*pre_unit)) as montoTotal
                FROM inventario.articulo inner join inventario.transaccion on articulo.codigo_articulo = transaccion.codigo_articulo
                inner join inventario.ingreso on transaccion.id_transaccion=ingreso.id_ingreso
                where articulo.codigo_articulo = '$codigoArticulo'
                group by pre_unit_ant, exis_ant, cantidad, pre_unit) as MON"
            )))
            ->get();

    }


    public function editarExistencia($idProduct){

        $product = Articulo::findOrFail($idProduct);

        return view('articulos.editarExistencia', ['product' => $product]);

    }

    public function editarPrecio($idProduct){

        $product = Articulo::findOrFail($idProduct);

        return view('articulos.editarPrecio', ['product' => $product]);

    }

    public function editE(Request $request){

        $product = Articulo::findOrFail($request->input('idProduct'));


        DB::table('articulo')
        ->where('codigo_articulo', $request->input('idProduct'))
        ->update([
            'existencia'=>$request->input('existencia')
        ]);


        flash('Exisitencia del producto editada exitosamente', 'success');


        return redirect('/articulo/'.$product->codigo_articulo);


    }


    public function editP(Request $request){


        $product = Articulo::findOrFail($request->input('idProduct'));

        DB::table('articulo')
        ->where('codigo_articulo', $request->input('idProduct'))
        ->update([
            'precio_unitario'=>$request->input('precio')
        ]);


        flash('Precio del producto editado exitosamente', 'success');


        return redirect('/articulo/'.$product->codigo_articulo);


    }










}
