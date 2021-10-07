<?php

namespace sig\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;


abstract class EsPerfil
{
    private $auth;
    
   public function __construct(Guard $auth)
   {
        $this->auth = $auth;
   }

   abstract public function getPerfil();

    public function handle($request, Closure $next)
    {
     if(Auth::check()) {
         if ($this->auth->user()->perfil['name'] == ($this->getPerfil())) {

             if ($request->ajax() || $request->wantsJson()) {
                 return response('Unauthorized.', 401);
             } else {
                 return response(view('errors.501'));
             }
         }
         return $next($request);
     }else{
         return redirect('/');
     }
        
    }
}
