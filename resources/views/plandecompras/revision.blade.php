@extends('layouts.template')

@section('content')

<div class="container">
<div class="panel panel-danger">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Confirmar</strong>
			</h4>
		</div>
		<div class="panel-body">

			<h1><span class="label label-danger">Otros usuarios han agregado este producto en su plan, confirme su solicitud.</span></h1>

		</div>		
</div>
</div>

<div class="container">
<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>Detalles de las solicitud existentes</strong>
			</h4>
		</div>
		<div class="panel-body">

			@php
				$total = 0;
			@endphp

			@foreach($e as $k =>$p)

			<br>
			<label>SOLICITUD {{$k+1}}  </label>
			<br>
			<label>Nombre del producto:</label>{{$p->nombre_producto}}
			<br>
			<label>Categoria:</label>{{$p->categoria}}
			<br>
			<label>Cantidad solicitada:</label>{{$p->cantidad}}
			<br>
				@php
					$total = $p->cantidad + $total;

				@endphp
			@endforeach
			<br>
			<label>TOTAL: {{$total}}</label>

			<form method="POST" action="{{ route('plandecompras.confirmar') }}">
				{{ csrf_field() }}
				<div class="form-group">

					<input type="hidden" name="cantidad" id="cantidad" value="{{$request2[0]}}">
					<input type="hidden" name="nombre_producto" id="nombre_producto" value="{{$request2[1]}}">

					<input type="hidden" name="especificaciones" id="especificaciones" value="{{$request2[2]}}">

					<input type="hidden" name="precio" id="precio" value="{{$request2[3]}}">

					<input type="hidden" name="proveedor" id="proveedor" value="{{$request2[4]}}">

					<input type="hidden" name="cotizacion" id="cotizacion" value="{{$request2[5]}}">

					<input type="hidden" name="user_id" id="user_id" value="{{$request2[6]}}">

					<input type="hidden" name="categoria" id="categoria" value="{{$request2[7]}}">

					<input type="hidden" name="fecha" id="fecha" value="{{$request2[8]}}">

					<input type="hidden" name="estado" id="estado" value="{{$request2[9]}}">



					<button type="submit" class="btn btn-primary">Continuar</button>
					<a href="{{route('plan.index')}}" class="btn btn-danger">Cancelar</a>
				
				</div>
			</form>		



		</div>		
</div>
</div>



@endsection