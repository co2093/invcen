@extends('layouts.template')
@section('css')
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
@endsection

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Editar tipo de equipo</strong>
			</h4>
		</div>
		<div class="panel-body">
			{!! Form::open(array('route' => 'tipo.equipo.editar.post','class' => 'form-horizontal','method' => 'post')) !!}

			<input type="hidden" name="idtipo" value="{{$tipoEquipo->id_tipo_equipo}}">
			<div class="form-group">
				{{ csrf_field() }}

				{!!Form::label('Nombre', 'Nombre *', array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					{!!Form::text('nombre', $tipoEquipo->nombre_tipo_equipo, array('placeholder' => '','class' => 'form-control')) !!}
					<div class="error">
						<ul>@foreach($errors->get('nombre') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
			</div>			

			
			<div class="form-group">
				<div class="col-md-offset-2 col-md-7">
					<button type="submit" class="btn btn-primary">Guardar</button>
					<a href="javascript:window.history.back();" class="btn btn-default">Cancelar</a>
				</div>
			</div>

			{!! Form::close() !!}
		</div>
	</div>

@endsection
@section('script')
	<script src="{{asset('plugins/select2/js/select2.js')}}"></script>
	<script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });
	</script>
@endsection