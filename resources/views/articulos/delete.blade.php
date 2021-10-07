@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Eliminar producto</strong>
			</h4>
		</div>
		<div class="panel-body">
			@if($articulo)
				<div class="col-md-offset-1">
					<h4>¿Est&aacute; seguro que desea eliminar el siguiente producto?</h4>
				</div>
				<dl class="dl-horizontal">
					<dt>Espec&iacute;fico</dt>
					<dd>{{$articulo->id_especifico}} | {{$articulo->especifico->titulo_especifico}}</dd>
					<dt>C&oacute;d prod.: </dt>
					<dd>{{ $articulo->getCodigoArticuloReporte()}}</dd>
					<dt>Articulo: </dt>
					<dd>{{ $articulo->nombre_articulo}}</dd>
					<dt>Existencia: </dt>
					<dd>{{ $articulo->existencia}}</dd>
					<dt>Precio unitario: </dt>
					<dd>${{ number_format($articulo->precio_unitario,2,'.','') }}</dd>
				</dl>
				{!! Form::open(['method' => 'DELETE','route' => ['articulo.destroy', $articulo->codigo_articulo],'style'=>'display:inline']) !!}
				{{ csrf_field() }}
				<div class="col-md-offset-1">
					{!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
					<a href="{{ route('articulo.index')}}" class="btn btn-primary">Cancelar</a>
				</div>
				{!! Form::close() !!}
		</div>
	</div>
	@endif
@endsection