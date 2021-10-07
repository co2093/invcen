@extends('layouts.template')

@section('content')


<div class="panel-body table-responsive">
       
                <div class="box-header with-border">
                  <h3 class="box-title">CONFIRMA ELIMINAR EL SIGUIENTE ROL</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="form-horizontal">
	               {!!Form::open(['route'=>['roles.destroy',$rol->id],'method'=>'DELETE'])!!}

	               		<div class="panel panel-default">
							<table class="table table-hover ">							
							  
							    <tr class="row">
							    <th class="col-xs-1">Numero</th>
							    <td class="col-xs-6">{{$rol->id}}</td>
							    <td class="col-xs-5"></td>
							    </tr>
							    <tr class="row">
							    <th class="col-xs-1">Nombre</th>
							    <td class="col-xs-6">{{$rol->name}}</td>
							    <td class="col-xs-5 "></td>
							    </tr>  
							     <tr class="row">
							    <th class="col-xs-1">Direccion</th>
							    <td class="col-xs-6">{{$rol->description}}</td>
							    <td class="col-xs-5"></td>
							    </tr> 				           
												  
							</table>
						</div>
	            
	                  <div class="">
	                  		<a href="javascript:window.history.back();"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>
	                        <button type="submit" class="btn btn-danger">Eliminar</button>
	                  </div><!-- /.box-footer -->
	               {!!Form::close()!!}
               </div>
       

</div>
 @endsection
         
         
   
     
   
   

      








