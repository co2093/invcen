<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sig\Http\Controllers\Controller;
use sig\Models\Requisicion;
use sig\Http\Requests;
use DB;

class HomeController extends Controller
{
	 public function __construct()
    {
        try {
            $this->middleware('auth');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
       
    }
    
     public function index()
    {
        try{
            return view('home');
        } catch (Exception $ex) {
            return 'Codigo: ' . $ex->getCode() . ' Mensaje: ' . $ex->getMessage();
        }
    }
}
