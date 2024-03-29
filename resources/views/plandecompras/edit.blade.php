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

			<form method="POST" action="{{route('plandecompras.update')}}"  enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="idProduct" id="idProduct" value="{{$product->id}}">
				<input type="hidden" name="antiguo" id="antiguo" value="{{$nuevo->telefono}}">

				<div class="form-group">
				<div class="col-xs-offset-3">	
					<label>Nombre del producto</label>
					<textarea class="form-control rounded-0"  id="nombre_producto" name="nombre_producto" rows="3">{{$product->nombre_producto}}</textarea>
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
					<label>Unidad de medida</label>
					<input type="text" name="unidadmedida" id="unidadmedida" value="{{$product->unidad}}" class="form-control">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad solicitada</label>
					<input type="number" name="cantidad" min="0" id="cantidad" value="{{$product->cantidad}}" class="form-control" onchange="multiply()" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Proveedor</label>

					<select name="proveedor" id="proveedor" class="form-control">
							<option value="{{$product->proveedor}}">{{$product->proveedor}}</option>
						@foreach($proveedores as $c)
						@if($c->nombre!=$product->proveedor)
							<option value="{{$c->nombre}}">{{$c->nombre}}</option>
						@endif
						@endforeach

					</select>

				</div>
				</div>

				@if($nuevo)
				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Nombre de nuevo proveedor</label>
					<input type="text" name="nuevoproveedor" id="nuevoproveedor" value="{{$nuevo->nombre}}" class="form-control">
				</div>
				</div>

				
				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Teléfono de nuevo proveedor</label>
					<input type="tel" name="telefono" minlength="8" maxlength="9"  id="telefono" value="{{$nuevo->telefono}}" class="form-control">
				</div>
				</div>

				@endif

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio cotizado</label>
					<input type="number" step="any" min="0" name="precio" id="precio" value="{{$product->precio_unitario}}" class="form-control" onchange="multiply()" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46)">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Total</label>
					<input type="number" step="any" name="total" id="total" onchange="multiply()" value="{{$product->total}}" class="form-control">

				</div>
				</div>



				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="file"  name="cotizacion" id="cotizacion" class="form-control">
				</div>
				</div>

				<div class="form-group">
				<div class="col-xs-offset-3">
					<button type="submit" class="btn btn-primary" id="sub-btn" name="sub-btn">Confirmar</button>
					<a href=" javascript:window.history.back(); " class="btn btn-danger">Cancelar</a>
				</div>
				</div>


			</form>

		</div>		
</div>
</div>

@endsection

@section('script')
 <script type="text/javascript">
    $("#sub-btn").click(function(e) {
      var logoimg = document.getElementById("cotizacion");
            let size = cotizacion.files[0].size; 
            if (size > 100000000) {
                alert("La cotizacion no debe ser mayor a 1 GB");
                event.preventDefault(); 
            }
    });
</script>

<script type="text/javascript">

	function multiply(){

		var c = document.getElementById("cantidad").value;
		var p = document.getElementById("precio").value;

		var t = parseFloat(c)*parseFloat(p);

		document.getElementById("total").value = t; 

	}


</script>
@endsection