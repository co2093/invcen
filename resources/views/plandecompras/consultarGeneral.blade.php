@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Detalles del producto en bodega</strong>
			</h4>
		</div>
		<div class="panel-body">

		@if($articulo)
	 
     <dl class="dl-horizontal">
		<dt>Producto: </dt>
		   <dd>{{ $articulo->nombre_articulo}}
		</dd>
		
		<dt>Existencia:</dt>
		   <dd>{{$articulo->existencia}}</dd>
	 </dl>
	<br><br>
	 <div class="col-md">
         <a href="{{ route('plandecompras.resumen')}}" class="btn btn-primary">Vover</a>
     </div>            
 
 	@else

 	<dl class="dl-horizontal">
		<dt>Producto: </dt>
		   <dd>No existe en bodega
		</dd>
		
		<dt>Existencia:</dt>
		   <dd>0</dd>
	 </dl>



 	<br><br>
	 <div class="col-md">
         <a href="{{ route('plandecompras.resumen')}}" class="btn btn-primary">Vover</a>
     </div> 
 	@endif

		</div>
	</div>
@endsection