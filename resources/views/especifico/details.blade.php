@extends('layouts.template')

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Detalle de la Categoría</strong>
			</h4>
		</div>
		<div class="panel-body">

			@if($especifico)

				<dl class="dl-horizontal">
					<dt>N&uacute;mero: </dt>
					<dd>{{ $especifico->id}}</dd>

					<dt>Nombre: </dt>
					<dd>{{ $especifico->titulo_especifico }}</dd>

					<dt>Descripci&oacute;n: </dt>
					<dd>{{ $especifico->descripcion_epecifico }}</dd>
					<dt>Productos</dt><br/>
					<div class="col-md-offset-2">
						<ol>
							@foreach($especifico->articulo as $art)
								<li>
									{{$art->nombre_articulo}}
								</li>
							@endforeach
						</ol>
					</div>

				</dl>

				<div class="col-md-offset-1">
					<a href="{{ route('especifico.index')}}" class="btn btn-primary">Vover a la lista</a>
				</div>
		</div>
	</div>


	@endif

@endsection