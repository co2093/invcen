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

			<form method="POST" action="{{ route('plandecompras.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="user_id" id="user_id" value="{{Auth::User()->id}}">
				<div class="form-group">
				<div class="col-xs-offset-3">	
					<label>Nombre del producto</label>
					<input type="text" name="nombre_producto" id="nombre_producto" placeholder="" class="form-control" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Categoría</label>

					<select name="categoria" id="categoria" class="form-control">

						@foreach($categorias as $c)
							<option value="{{$c->titulo_especifico}}">{{$c->titulo_especifico}}</option>
						@endforeach

					</select>


				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Especificaciones</label>
					<textarea class="form-control rounded-0" id="especificaciones" name="especificaciones" rows="5"></textarea>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad</label>
					<input type="number" name="cantidad" id="cantidad" placeholder="1" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio cotizado</label>
					<input type="number" step="any" name="precio" id="precio" placeholder="0.00" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
				</div>
				</div>


				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="file" name="cotizacion" id="cotizacion" class="form-control" >
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