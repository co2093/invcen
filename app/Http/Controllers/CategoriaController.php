<?php
namespace sig\Http\Controllers;
use Illuminate\Http\Request;
use sig\Http\Requests;
use DB;
use Session;
use sig\Models\Categoria;
use Exception;
use Auth;
use Datatables;

class CategoriaController extends Controller {

    public function __construct()
    {
        try {
            $this->middleware('auth');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

     
    public function index()
    {
        /*return view("categoria.index");*/
        try 
        {           
            $categorias = Categoria::orderBy('id_categoria','asc')->get();         
            return view('categoria.index', ['categorias' => $categorias]);
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

    public function create()
    {
        return view("categoria.create");
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required |regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/ |unique:categoria,nombre',
            //'descripcion' => 'regex: /^[a-zA-Z0-9áéíóúñÑ\s\/]*$/'
        ]);
        try {


            DB::table('categoria')->insert([
                'id_categoria' => 2,
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion')
            ]);

    //        $newcategoria= new Categoria();
      //      $newcategoria->nombre =  $request->input('nombre');
        //    $newcategoria->descripcion = $request->input('descripcion');
          //  $newcategoria->save();
           
            flash('Categoría guardado exitosamente', 'success');
            return redirect()->route('categoria.index');
        }catch (Exception $ex){
            return 'Codigo: '.$ex->getCode().' Mensaje: '.$ex->getMessage();
        }
    }

 
}