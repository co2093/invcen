@extends('layouts.template')

@section('content')


<div class="container">

	<div class="panel panel-info">

		<div class="panel-heading"><strong>Nota</strong></div>
    	<div class="panel-body">
    		Actualmente hay <strong>{{$product->existencia}}</strong> existencias del articulo <strong>{{$product->nombre_articulo}}</strong> en bodega.
    	</div>
  	</div>	<div class="panel panel-success">




<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Agregar al plan de compras articulo: {{$product->nombre_articulo}}</strong>
			</h4>
		</div>

		<div class="panel-body">

			<form method="POST" action="{{route('plandecompras.store')}}" accept-charset="UTF-8" enctype="multipart/form-data">
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
					<label>Categoría</label>

					<select name="categoria" id="categoria" class="form-control">

						<option value="{{$product->especifico->titulo_especifico}}">{{$product->especifico->titulo_especifico}}</option>

						@foreach($categorias as $c)
							@if($product->especifico->titulo_especifico != $c->titulo_especifico)
								<option value="{{$c->titulo_especifico}}">{{$c->titulo_especifico}}</option>
							@endif
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
					<label>Unidad de medida</label>
					<input type="text" name="unidadmedida" id="unidadmedida" value="{{$product->unidad->nombre_unidadmedida}}" class="form-control">
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Cantidad solicitada</label>
					<input type="number" name="cantidad" id="cantidad" class="form-control" onchange="multiply()" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Proveedor</label>

					<select name="proveedor" id="proveedor" class="form-control">

						<option value=" ">  </option>
						@foreach($proveedores as $c)
							<option value="{{$c->nombre}}">{{$c->nombre}}</option>
						@endforeach

					</select>
				</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">

						
						<button type="button" class="btn btn-success" onclick="toggle();">Agregar proveedor</button>


					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-offset-3">
					<label id="nuevolbl" hidden="hidden">Nombre de nuevo proveedor</label>
					<input type="hidden" name="nuevoproveedor" id="nuevoproveedor" class="form-control">
				</div>
				</div>

				
				<div class="form-group">
					<div class="col-xs-offset-3">
					<label id="nuevolbl2" hidden="hidden">Teléfono de nuevo proveedor</label>
					<input type="hidden" name="telefono" minlength="8" maxlength="9"  id="telefono" class="form-control">
				</div>
				</div>




				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Precio cotizado</label>
					<input type="number" step="any" name="precio" id="precio" value="{{round(($product->precio_unitario),2)}}" class="form-control" onchange="multiply()">

				</div>
				</div>


				<div class="form-group">
					<div class="col-xs-offset-3">
					<label>Total</label>
					<input type="number" step="any" name="total" id="total" class="form-control" onchange="multiply()">

				</div>
				</div>




				<div class="form-group">
				<div class="col-xs-offset-3">
					<label>Cotización</label>
					<input type="file" name="cotizacion" id="cotizacion" class="form-control">
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

<script type="text/javascript">

	function toggle(){

		var lbl1 = document.getElementById("nuevolbl");

		var lbl2 = document.getElementById("nuevolbl2");

		document.getElementById("nuevoproveedor").type="text";

		lbl1.removeAttribute("hidden");

		lbl2.removeAttribute("hidden");

		document.getElementById("telefono").type="text";       

	}

</script>

@endsection