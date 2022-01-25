@extends('layouts.template')

@section('content')


<div class="container">
<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Editar producto del plan de compras</strong>
			</h4>
		</div>
		<div class="panel-body">

			<form method="POST" action="{{route('plandecompras.update')}}">
				{{ csrf_field() }}
				<input type="hidden" name="idProduct" id="idProduct" value="{{$product->id}}">
				<div class="form-group">
				<div class="col-xs-offset-3">	
					<label>Nombre del producto</label>
					<input type="text" name="nombre_producto" id="nombre_producto" value="{{$product->nombre_producto}}" class="form-control" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Categoría</label>

					<select name="categoria" id="categoria" class="form-control">
							<option value="{{$product->categoria}}">{{$product->categoria}}</option>
						@foreach($categorias as $c)
						@if($c->titulo_especifico!=$product->categoria)
							<option value="{{$c->titulo_especifico}}">{{$c->titulo_especifico}}</option>
						@endif
						@endforeach

					</select>


				</div>
				</div>


				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Especificaciones</label>
					<textarea class="form-control rounded-0" id="especificaciones" name="especificaciones" rows="5">{{$product->especificaciones}}</textarea>

				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad</label>
					<input type="number" name="cantidad" id="cantidad" value="{{$product->cantidad}}" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio cotizado</label>
					<input type="number" step="any" name="precio" id="precio" value="{{$product->precio_unitario}}" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
				</div>
				</div>



				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="file"  name="cotizacion" id="cotizacion" value="{{$product->cotizacion}}" class="form-control">
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