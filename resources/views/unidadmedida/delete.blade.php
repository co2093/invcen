@extends('layouts.template')

@section('content')

	<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Eliminar unidad de medida</strong>
			</h4>
		</div>
		<div class="panel-body">

    @if($unidad)
	 
	    <div class="col-md-offset-1">
	        <h4>¿Est&aacute; seguro que desea eliminar la siguiente unidad de medida?</h4>
	    </div>
        <dl class="dl-horizontal col-md-offset-1"> 
	        <dt>Unidad de medida: </dt> 
		    <dd>{{ $unidad->nombre_unidadmedida}}</dd>			   	   
	    </dl>
	    {!! Form::open(['method' => 'DELETE','route' => ['unidad.destroy', $unidad->id_unidad_medida],'style'=>'display:inline']) !!}
	        <div>
                {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
			    <a href="{{ route('unidad.index')}}" class="btn btn-primary">Cancelar</a>
		    </div>
        {!! Form::close() !!}
    @endif
		</div>
	</div>

@endsection