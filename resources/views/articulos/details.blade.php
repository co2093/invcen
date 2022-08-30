@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Detalle producto</strong>
			</h4>
		</div>
		<div class="panel-body">

		@if($articulo)
	 
     <dl class="dl-horizontal">
		 <dt>Espec&iacute;fico: </dt>
		 <dd>{{$articulo->especifico->id}} | {{$articulo->especifico->titulo_especifico}}</dd>

	    <dt>C&oacute;d. prod.: </dt>
		   <dd>{{$articulo->getCodigoArticuloReporte()}}</dd>
		<dt>Producto: </dt>
		   <dd>{{ $articulo->nombre_articulo}}
		</dd>
		<dt>Unidad de medida: </dt> 
		   <dd>{{$articulo->unidad->nombre_unidadmedida }}</dd>
		<dt>Existencia:</dt>
		   <dd>{{$articulo->existencia}}</dd>
		<dt>Precio unitario:</dt>
		   <dd>${{number_format($articulo->precio_unitario,2,'.','')}}</dd>
		<dt>Total:</dt>
		   <dd>${{ number_format(($articulo->precio_unitario*$articulo->existencia),2,'.','') }}</dd>
		@if($articulo->es_reactivo=='S')
		<dt>Reactivo:</dt>
		   <dd>Si</dd>
		<dt>Formula:</dt>
		   <dd>{{$articulo->formula}}</dd>
		@endif
	 </dl>

	<div class="form-group">
		<div class="col-xs">
			<a href="{{ route('articulo.editar.existencia', $articulo->codigo_articulo) }}" class="btn btn-info">Modificar existencia</a>
			<a href="{{ route('articulo.editar.precio', $articulo->codigo_articulo) }}" class="btn btn-success">Modificar precio</a>
		</div>
	</div>

	<br><br>
	 <div class="col-md">
         <a href="{{ route('articulo.index')}}" class="btn btn-primary">Vover a la lista</a>
     </div>            
 
 @endif
		</div>
	</div>
@endsection