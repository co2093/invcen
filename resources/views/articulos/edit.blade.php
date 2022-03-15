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
				<strong>Editar producto</strong>
			</h4>
		</div>
		<div class="panel-body">
			@if($articulo)
				{!! Form::open(array('route' => ['articulo.update','codigo_articulo' => $articulo->codigo_articulo],'class' => 'form-horizontal','method' => 'put')) !!}
				{{ csrf_field() }}

				<div class="form-group">
					{!!Form::label('Codigo articulo', 'Codigo producto', array('class' =>'control-label col-md-2' )) !!}
					<div class="col-md-7">
						{!!Form::text('codigo', $articulo->getCodigoArticuloReporte(), array('placeholder' => 'EE001','class' => 'form-control','disabled')) !!}
					</div>
				</div>

				<div class="form-group">
					{!!Form::label('Nombre', 'Nombre *', array('class' =>'col-md-2 control-label' )) !!}
					<div class="col-md-7">
						{!!Form::textarea('nombre', $articulo->nombre_articulo, array('class' => 'form-control rounded-0', 'rows' => 35, 'cols' => 35, 'style' => 'resize:both')) !!}
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
								@if($especifico->id == $articulo->especifico->id)
									<option value={{$especifico->id}} selected>
										{{$especifico->getEspecificoTitulo()}}
									</option>
								@else
									<option value={{$especifico->id}}>
										{{$especifico->getEspecificoTitulo()}}
									</option>
								@endif

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
						<select name="unidad" class="form-control js-example-basic-single js-example-responsive" style="width: 100%">
							@foreach ($unidades as $unidad)
								@if($unidad->id_unidad_medida == $articulo->id_unidad_medida)
									<option value={{$unidad->id_unidad_medida}} selected>
										{{$unidad->nombre_unidadmedida}}
									</option>
								@else
									<option value={{$unidad->id_unidad_medida}}>
										{{$unidad->nombre_unidadmedida}}
									</option>
								@endif

							@endforeach
						</select>
						<div class="error">
							<ul>@foreach($errors->get('unidad') as $msg)<li>{{$msg}}</li> @endforeach</ul>
						</div>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label>REACTIVO
					  <input 
					  	type="checkbox" 
					  	name="es_reactivo" 
					  	id="es_reactivo"					  	
					  	@if($articulo->es_reactivo=='S')
					  		checked ="checked"
					  		value="1" 
					  	@else
					  		value="0" 
					  	@endif
					  	onclick="mostrarEsReactivo(this);">				 
					</label>
				</div>				
				<div id="seccion_reactivo" @if($articulo->es_reactivo=='N')style="display:none;" @endif>	
					<div class="form-group">				
						{!!Form::label('formula', 'Formula *', array('class' =>'col-md-2 control-label' )) !!}
						<div class="col-md-7">
							{!!Form::text('formula', $articulo->formula, array('placeholder' => '','class' => 'form-control')) !!}
							<div class="error">
								<ul>@foreach($errors->get('formula') as $msg)<li>{{$msg}}</li> @endforeach</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-7">

						<button type="submit" class="btn btn-primary">Actualizar</button>
						<a href="{{route('articulo.index')}}" class="btn btn-primary">Cancelar</a>

					</div>
				</div>

				{!! Form::close() !!}
		</div>
	</div>
	@endif

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