@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Editar existencia del producto: {{$product->codigo_articulo}}</strong>
			</h4>
		</div>
		<div class="panel-body">



			<form method="POST" action="{{route('articulo.editar.e')}}">
				{{ csrf_field() }}
				<input type="hidden" name="idProduct" id="idProduct" value="{{$product->codigo_articulo}}">




				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Existencia</label>
					<input type="number" name="existencia" id="existencia" value="{{$product->existencia}}" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
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