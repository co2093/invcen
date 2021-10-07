@extends('layouts.template')

@section('content')


<div class="panel-body table-responsive">
       
                <div class="box-header with-border">
                  <h3 class="box-title">¿Est&aacute; seguro que desea eliminar el usuario?</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="form-horizontal">
	               {!!Form::open(['route'=>['usuario.destroy',$usuario->id],'method'=>'DELETE'])!!}

	               		<div class="panel panel-default">
							<table class="table table-hover ">							
							  
							    <tr>
								    <tr class="row">
								    <th class="col-xs-1">Nombre</th>
								    <td class="col-xs-6">{{$usuario->name}}</td>
								    <td class="col-xs-5 "></td>
							    </tr> 
							    </tr>
								    <tr class="row">
								    <th class="col-xs-1">Usuario</th>
								    <td class="col-xs-6">{{$usuario->usuario}}</td>
								    <td class="col-xs-5 "></td>
							    </tr> 							   
							    <tr class="row">
								    <th class="col-xs-1">Perfil</th>
								    <td class="col-xs-6">{{$usuario->perfil->name}}</td>
								    <td class="col-xs-5"></td>
							    </tr> 
							    <tr class="row">
								    <th class="col-xs-1">Correo</th>
								    <td class="col-xs-6">{{$usuario->email}}</td>
								    <td class="col-xs-5"></td>
							    </tr>
													         
												  
							</table>
						</div>
	            
	                  <div class="">
	                  		<a href="{{Route('usuario.index')}}"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>
	                        <button type="submit" class="btn btn-danger">Eliminar</button>
	                  </div><!-- /.box-footer -->
	               {!!Form::close()!!}
               </div>
       

</div>
 @endsection


