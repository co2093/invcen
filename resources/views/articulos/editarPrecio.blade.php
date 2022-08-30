@extends('layouts.template')

@section('content')

	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Editar precio del producto: {{$product->nombre_articulo}}</strong>
			</h4>
		</div>
		<div class="panel-body">




			<form method="POST" action="{{route('articulo.editar.p')}}">
				{{ csrf_field() }}
				<input type="hidden" name="idProduct" id="idProduct" value="{{$product->codigo_articulo}}">



				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio</label>
					<input type="number" step="any" name="precio" id="precio" value="{{round($product->precio_unitario,2)}}" class="form-control" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
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