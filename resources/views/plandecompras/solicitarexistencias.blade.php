@extends('layouts.template')

@section('content')


<div class="container">

	<div class="panel panel-info">

		<div class="panel-heading"><strong>Nota</strong></div>
    	<div class="panel-body">
    		Actualmente hay <strong>{{$product->existencia}}</strong> existencias del articulo <strong>{{$product->nombre_articulo}}</strong> en bodega.
    	</div>
  	</div>


<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Agregar al plan de compras articulo: {{$product->nombre_articulo}}</strong>
			</h4>
		</div>

		<div class="panel-body">

			<form method="POST" action="{{route('plandecompras.store')}}">
				{{ csrf_field() }}
				<input type="hidden" name="user_id" id="user_id" value="{{Auth::User()->id}}">
				<div class="form-group">
				<div class="col-xs-offset-3">	
					<label>Nombre del producto</label>
					<input type="text" name="nombre_producto" id="nombre_producto" value="{{$product->nombre_articulo}}" class="form-control" readonly="readonly">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Especificaciones</label>
					<input type="text" name="especificaciones" id="especificaciones" class="form-control">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad</label>
					<input type="number" name="cantidad" id="cantidad" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio unitario</label>
					<input type="number" step="any" name="precio" id="precio" value="{{$product->precio_unitario}}" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Proveedor</label>
					<input type="text" name="proveedor" id="proveedor" class="form-control">
				</div>
				</div>

				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="number" step="any" name="cotizacion" id="cotizacion" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
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
</div>

@endsection