@extends('layouts.template')

@section('content')


<div class="container">
<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Agregar nuevo producto al plan de compras</strong>
			</h4>
		</div>
		<div class="panel-body">

			<form method="POST" action="{{ route('plandecompras.store') }}">
				{{ csrf_field() }}
				<input type="hidden" name="user_id" id="user_id" value="{{Auth::User()->id}}">
				<div class="form-group">
				<div class="col-xs-offset-3">	
					<label>Nombre del producto</label>
					<input type="text" name="nombre_producto" id="nombre_producto" placeholder="Nombre del producto" class="form-control" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Especificaciones</label>
					<input type="text" name="especificaciones" id="especificaciones" placeholder="Especificaciones" class="form-control">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad</label>
					<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio unitario</label>
					<input type="number" step="any" name="precio" id="precio" placeholder="0.00" class="form-control">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Proveedor</label>
					<input type="text" name="proveedor" id="proveedor" placeholder="Proveedor" class="form-control">
				</div>
				</div>

				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="number" step="any" name="cotizacion" id="cotizacion" placeholder="0.00" class="form-control">
				</div>
				</div>

				<div class="form-group">
				<div class="col-xs-offset-3">
					<button type="submit" class="btn btn-primary">Agregar</button>
					<a href=" javascript:window.history.back(); " class="btn btn-danger">Cancelar</a>
				</div>
				</div>


			</form>

		</div>		
</div>
</div>

@endsection