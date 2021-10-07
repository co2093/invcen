@extends('layouts.template')

@section('content')

              <div class="panel panel-default">
                <div class="box-header with-border">
                  <h3 class="box-title">MODIFICAR DATOS DEL ROL</h3>
                </div><!-- /.box-header -->
            
                       
                <div class="form-horizontal">
	               {!!Form::model($rol,['route'=>['roles.update',$rol->id],'method'=>'patch'])!!}
	                <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                  <div class="box-body">

	                   <div class="form-group">
	                      <label for="name" class="col-sm-2 control-label">Numero</label>
	                      <div class="col-sm-6">
	                        <input type="text" class="form-control" id="id" name="id" value="{{$rol->id}}" readonly>
	                      </div>
	                    </div> 	                    
	                    <div class="form-group">
	                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
	                      <div class="col-sm-6">
	                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$rol->name}}" >
	                            <div class="error">
                                    <ul>@foreach($errors->get('nombre') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                                </div>
	                      </div>
	                    </div>   
	                    <div class="form-group">
	                      <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
	                      <div class="col-sm-6">
	                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{$rol->description}}">
	                            <div class="error">
                                    <ul>@foreach($errors->get('descripcion') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                                </div>
	                      </div>
	                    </div>
	                    
	                               
	                  </div><!-- /.box-body -->
	                  <div class="box-footer">
	                  			<a href="javascript:window.history.back();"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>
	                        <button type="submit" class="btn btn-info">Actualizar</button>
	                  </div><!-- /.box-footer -->
	               {!!Form::close()!!}
               </div>
              </div><!-- /.box -->


 @endsection
