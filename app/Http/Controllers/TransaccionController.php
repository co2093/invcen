<?php

namespace sig\Http\Controllers;

use Illuminate\Http\Request;

use sig\Http\Requests;
use Exception;
use sig\Models\Transaccion;

class TransaccionController extends Controller
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
        try {
            $transacciones = Transaccion::orderBy('id_transaccion', 'asc')->get();
            return view('transacciones.index', ['transacciones' => $transacciones]);
        }catch (Exception $ex){
            return $ex->getMessage()+ $ex->getCode();
        }
    }

        public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
