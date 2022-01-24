@extends('layouts.template')
@section('css')
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
	<style type="text/css">
		input[type=checkbox] {
		  transform: scale(1.5);
		}
	</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong>Habilitar plan de compras</strong></div>
                <div class="panel-body">
                   
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('habilitar/update') }}" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-md-4 control-label">Estado actual</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ $estado }}"   disabled="true">


                            </div>
                        </div>



                        <div class="form-group">
  							<label for="estado" class="col-md-4 control-label">Seleccionar estado</label>
  							<div class="col-md-6">
  								<select class="form-control" id="periodoEstado" name="periodoEstado">
    								<option value="1">Habilitado</option>
    								<option value="0">Deshabilitado</option>
  								</select>
  							</div>
						</div>

                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                                <a href="/home"><button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button></a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

        <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong>Reiniciar plan de compras</strong></div>
                <div class="panel-body text-center">                   
                                <label class="control-label text-danger">Con esta acción se daría por finalizado el período de compras y se reiniciaría todo el plan de compras.</label> 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4"><br>
                                <a href="{{ route('plandecompras.finalizar') }}" class="btn btn-danger btn-block">REINICIAR</a>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


</div>


@endsection