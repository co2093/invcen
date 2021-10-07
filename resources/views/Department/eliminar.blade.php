@extends('layouts.template')

@section('content')

	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Eliminar Usuario/Unidad</strong>
			</h4>
		</div>
		<div class="panel-body">
			@if($department)
				<div class="col-md-offset-1">
					<h4>¿Est&aacute; seguro que desea eliminar el Usuario/Unidad?</h4>
				</div>
				<dl class="dl-horizontal col-md-offset-1">
					<dt>Usuario/Unidad: </dt>
					<dd>{{ $department->name}}</dd>
					<dt>Descripcion: </dt>
					<dd>{{ $department->descripcion}}</dd>
					<dt>Encargado: </dt>
					<dd>{{ $department->encargado}}</dd>
				</dl>
				{!! Form::open(['method' => 'DELETE','route' => ['departamento.destroy', $department->id],'style'=>'display:inline']) !!}
				{{ csrf_field() }}

				<div>
					{!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
					<a href="javascript:window.history.back();" class="btn btn-primary">Cancelar</a>
				</div>
				{!! Form::close() !!}
			@endif
		</div>
	</div>
@endsection