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


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Editar existencia</strong>
			</h4>
		</div>
		<div class="panel-body">
			
				{!! Form::open(array('route' => ['existencia.update','codigo_articulo' => $articulo->codigo_articulo],'class' => 'form-horizontal','method' => 'put')) !!}
				{{ csrf_field() }}

				<div class="form-group">
					{!!Form::label('Codigo articulo', 'Codigo producto', array('class' =>'control-label col-md-2' )) !!}
					<div class="col-md-7">
						{!!Form::text('codigo', $articulo->getCodigoArticuloReporte(), array('placeholder' => 'EE001','class' => 'form-control','disabled')) !!}
					</div>
				</div>

				<div class="form-group">
					{!!Form::label('Nombre', 'Nombre ', array('class' =>'col-md-2 control-label' )) !!}
					<div class="col-md-7">
						{!!Form::text('nombre', $articulo->nombre_articulo, array('placeholder' => 'Escoba, Azucar','class' => 'form-control','disabled')) !!}
					</div>
				</div>


				<div class="form-group">
					{!!Form::label('Existencia', 'Existencia ', array('class' =>'col-md-2 control-label' )) !!}
					<div class="col-md-7">
						{!!Form::number('existenciaNueva', $articulo->existencia, array('placeholder' => '0000','class' => 'form-control')) !!}
					</div>
				</div>



			

				<div class="form-group">
					<div class="col-md-offset-2 col-md-7">

						<button type="submit" class="btn btn-primary">Actualizar</button>
						<a href="{{route('existencia.index')}}" class="btn btn-primary">Cancelar</a>

					</div>
				</div>

				{!! Form::close() !!}
		</div>
	</div>

@endsection



