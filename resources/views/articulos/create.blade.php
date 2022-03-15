@extends('layouts.template')
@section('css')
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
	<style type="text/css">
		input[type=checkbox] {
		  transform: scale(1.5);
		}
	</style>
@endsection

@section('content')
	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Nuevo producto</strong>
			</h4>
		</div>
		<div class="panel-body">
			{!! Form::open(array('route' => 'articulo.store','class' => 'form-horizontal','method' => 'post')) !!}


			<div class="form-group">
				{{ csrf_field() }}

				{!!Form::label('Nombre', 'Nombre *', array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					{!!Form::textarea('nombre', null, array('placeholder' => 'Escoba, Azucar','class' => 'form-control rounded-0', 'rows' => 35, 'cols' => 35, 'style' => 'resize:both')) !!}
					<div class="error">
						<ul>@foreach($errors->get('nombre') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
			</div>

			<div class="form-group">
				{!!Form::label('Especifico', 'Especifico *', array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					<select name="especifico" class="form-control js-example-basic-single js-example-responsive" style="width: 100%">
						@foreach ($especificos as $especifico)
							<option value={{$especifico->id}}>
								{{$especifico->getEspecificoTitulo()}}
							</option>
						@endforeach
					</select>
					<div class="error">
						<ul>@foreach($errors->get('especifico') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
			</div>

			<div class="form-group">
				{!!Form::label('Unidad de medida', 'Unidad de medida *', array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					<select name="unidad" class="form-control js-example-basic-single" style="width: 100%">
						@foreach ($unidades as $unidad)
							<option value={{$unidad->id_unidad_medida}}>
								{{$unidad->nombre_unidadmedida}}
							</option>
						@endforeach
					</select>
					<div class="error">
						<ul>@foreach($errors->get('unidad') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
			</div>
			<div class="form-group col-md-12">
				<label>REACTIVO
				  <input type="checkbox" name="es_reactivo" id="es_reactivo" value="0" onclick="mostrarEsReactivo(this);">				 
				</label>
			</div>				
			<div id="seccion_reactivo" style="display:none;">	
				<div class="form-group">				
					{!!Form::label('formula', 'Formula *', array('class' =>'col-md-2 control-label' )) !!}
					<div class="col-md-7">
						{!!Form::text('formula', null, array('placeholder' => '','class' => 'form-control')) !!}
						<div class="error">
							<ul>@foreach($errors->get('formula') as $msg)<li>{{$msg}}</li> @endforeach</ul>
						</div>
					</div>
				</div>
			</div>				
			
			<div class="form-group">
				<div class="col-md-offset-2 col-md-7">
					<button type="submit" class="btn btn-primary">Guardar</button>
					<a href="{{route('articulo.index')}}" class="btn btn-primary">Cancelar</a>
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

    function mostrarEsReactivo(checkbox)
    {
    	if(checkbox.checked)
    	{
    		$("#seccion_reactivo").show();
    		$("#es_reactivo").val(1);
    	}
    	else if(!checkbox.checked)
    	{
    		$("#seccion_reactivo").hide();
    		$("#es_reactivo").val(0);
    	}
    }
</script>
@endsection