<?php

namespace sig\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use sig\Http\Requests;
use sig\Models\Role;
use sig\Models\Department;
use sig\User;
use DB;
use sig\Http\Requests\User\UserCreateRequest;
use sig\Http\Requests\User\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Foundation\Auth\ThrottlesLogins;

use Auth;
use Laracasts\Flash\Flash;

class UsersController extends Controller
{

    use AuthenticatesUsers;
    //use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $loginView = 'auth.login';

    public function index(){

       	$usuarios = User::all();
       	return view('auth.index')->with('usuarios',$usuarios);
    }

    public function authenticate(Request $request)
    {
      //return $request->contraseña;
    	if (Auth::attempt(['usuario' => $request->input('nombre'), 'password' => $request->input('contraseña'), 'activo' => 'true'])) 
    	{
            return redirect()->intended('home');
		}
		else
		{
     
			return redirect('/')
      ->withInput($request->only('nombre'))
      ->withErrors([
          'nombre'=>'Las credenciales no son validas.'
        ]);
		}
		
       
    }
    public function logout(){
    	Auth::logout();
      \Session::flush();
    	return redirect('/');
    }
  
    public function getRegister(){
    	$roles = Role::where('id','!=',4)->select('name','id')->get();    	
      return view('auth.register',['roles'=>$roles]);
    }
     public function create($id)
    {
      $roles = Role::where('id','!=',4)->select('name','id')->get();     
      return view('auth.insertar',['roles'=>$roles,'departamento'=>$id]);
    }
    public function postRegister(UserCreateRequest $request){

      if(Auth::User()->perfil['name'] == 'ADMINISTRADOR BODEGA')
      {
        $depto= Department::FindOrFail($request->input('depto')); 
        User::create([
            'name' =>$request->input('name'), 
            'usuario' =>$request->input('usuario'),       
            'email' =>$request->input('email'),
            'password' => bcrypt($request['password']),
            'activo' =>'true',  
            'perfil_id'=>'4',
            'departamento_id'=>$depto->id,
            ]
        );           
       
        $depto->update([           
            'encargado' =>$request->input('name'),                                 
          ]);

          flash('usuario creado exitosamente','success');
          return redirect()->route('departamento.index');
      }
      else
      {
      	User::create([
            'name' =>$request->input('name'),	
            'usuario' =>$request->input('usuario'),  	    
            'email' =>$request->input('email'),
		        'password' => bcrypt($request['password']),
		        'activo' =>'true',	
		        'perfil_id'=>$request->input('perfil'),
		        ]
    		);
         //flash('guardado','success');
         $usuarios = User::all();
          flash('usuario creado exitosamente','success');
          //return view('auth.index')->with('usuarios', $usuarios);
          return redirect()->route('usuario.index');

      }
    }
    public function getEdit($id){
    	  $usuario = User::FindOrFail($id);
       	$roles = Role::all();    	
    	  return view('auth.edit',['roles'=>$roles,'usuario'=>$usuario]);
    }

    //funcion actualizar usuario
    public function update(Request $request, $id){

      $this->validate($request,[
            'nombre'=>'required|max:100|regex: /^[a-zA-Z0-9áéíóúñÑ,\s\-\_\.]*$/|unique:users,name,'.$id.',id',
            'email' => 'required|email|max:255|unique:users,email,'.$id.',id',
            'usuario' => 'required|max:30|unique:users,usuario,'.$id.',id',
            'password' => 'confirmed|min:6',

        ]); 
      
         //recuperar usuario a actualizar
        $usuario = User::FindOrFail($id);
        $depto=Department::where('id','=',$usuario->departamento_id)->first();
        if($depto){
          $depto->update([           
            'encargado' =>$request->input('nombre'),                                 
          ]);
        }
        

         if($request->input('depto'))//if deptos
        {
          if($request->input('password'))
          {
            $usuario->update([           
            'name' =>$request->input('nombre'),
            'usuario' =>$request->input('usuario'),        
            'email' =>$request->input('email'),
            'password' => bcrypt($request['password']),             
          ]);
          }
          else
          {
            $usuario->update([           
            'name' =>$request->input('nombre'),       
            'email' =>$request->input('email'),
            'usuario' =>$request->input('usuario'),               
          ]);
          }
          
        flash('actualizado','success');
        return redirect()->back();
        }//fin if deptos
        else
        {
          if($request->input('password'))
          {
             $usuario->update([          
            'name' =>$request->input('nombre'),           
            'password' => bcrypt($request['password']),                 
            'email' =>$request->input('email'), 
            'usuario' =>$request->input('usuario'),         
            'activo' =>$request->input('activo'),  
            'perfil_id'=>$request->input('perfil')
          ]);
          }
          else
          {
             $usuario->update([          
            'name' =>$request->input('nombre'),                         
            'email' =>$request->input('email'), 
            'usuario' =>$request->input('usuario'),         
            'activo' =>$request->input('activo'),  
            'perfil_id'=>$request->input('perfil')
          ]);
          }
        
        flash('actualizado','success');
        $usuarios = User::all();
        return view('auth.index')->with('usuarios',$usuarios); 
        }    
        
    }//fin de update

     public function mostrar($id)
    {
        $usuario= User::FindOrFail($id);
        return view('auth.delete')->with('usuario',$usuario);
    }

   public function destroy($id)
    {
      $u=User::FindOrFail($id);

      if($u->perfil['name'] == 'DEPARTAMENTO')
      {
        $departamento = Department::where('id',$u->departamento_id)->first(); 
         if($departamento){
          $departamento->update([           
            'encargado' =>'No Definido',                                 
          ]);
        }  
      }           
       
      $u->delete();
            flash('eliminado exitosamente','success');
            //$usuarios = User::all();
            //return view('auth.index')->with('usuarios',$usuarios);
        return redirect()->route('usuario.index');
        
    }

     public function edit($id)
    {
        $usuario = User::FindOrFail($id);
        $roles = Role::all();     
        return view('auth.actualizar',['roles'=>$roles,'usuario'=>$usuario]);
    }
}
