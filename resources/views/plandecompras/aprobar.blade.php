@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Aprobar compra</strong>
			</h4>
		</div>
		<div class="panel-body">


		<dl class="dl-horizontal">
			<dt>Nombre del producto: </dt>
		 	<dd>{{$product->nombre_producto}}</dd>
		 	<dt>Categoria:</dt>
		 	<dd>{{$product->categoria}}</dd>
		 	<dt>Especificaciones:</dt>
		 	<dd>{{$product->especificaciones}}</dd>
		 	<dt>Unidad de medida:</dt>
		 	<dd>{{$product->unidad}}</dd>
		 	<dt>Precio unitario:</dt>
		 	<dd>${{number_format(($product->precio_unitario),2,'.','')}}</dd>
	    	<dt>Cantidad solicitada:</dt>
	    	<dd><label>{{$product->cantidad}}</label></dd>
	    	<dt>Usuario que lo solicita:</dt>
		 	<dd>{{$user->name}}</dd>
	    	<dt></dt>
	    	<dd></dd>	
	 	</dl>

			<form method="POST" action="{{route('plandecompras.finalizarCompra')}}">
				{{ csrf_field() }}
				<input type="hidden" name="idProduct" id="idProduct" value="{{$product->id}}">
				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad aprobada</label>
					<input type="number" name="aprobada" id="aprobada" value="{{$product->cantidad}}" min="0" max="{{$product->cantidad}}" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

			<div class="form-group">
				<div class="col-xs-offset-3">
					<button type="submit" class="btn btn-primary">Confirmar</button>
         			<a href=" javascript:window.history.back(); " class="btn btn-danger">Cancelar</a>
				</div>
			</div>

			</form>






		</div>
	</div>
@endsection