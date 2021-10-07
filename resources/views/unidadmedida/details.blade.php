@extends('layouts.template')

@section('content')

	@if($unidad)
		<div class="panel panel-info">
			<div class="panel-heading" role="tab">
				<h4 class="panel-title">
					<strong>Detalle de unidad de medida</strong>
				</h4>
			</div>
			<div class="panel-body">
				<a href="{{route('articulo.index')}}" data-toggle="modal" class="btn btn-success btn-sm admin" >Ir a administracion de productos</a>
				<dl class="dl-horizontal">
					<dt>Unidad de medida: </dt>
					<dd>{{ $unidad->nombre_unidadmedida}}</dd>
					<dt>Productos</dt><br/>
					<div class="col-md-offset-2">
						<ol>
							@foreach($unidad->articulo as $art)
								<li>
									{{$art->nombre_articulo}}
								</li>
							@endforeach
						</ol>
					</div>
				</dl>

				<div class="col-md-offset-1">
					<a href="{{ route('unidad.index')}}" class="btn btn-primary">Vover a la lista</a>
				</div>
			</div>
		</div>
	@endif
@endsection