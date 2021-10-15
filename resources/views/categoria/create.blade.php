@extends('layouts.template')

@section('content')
<div class="panel panel-info">
	<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Nueva Categoría</strong>
			</h4>
		</div>
        <div class="panel-body">
			
            <div class="form-horizontal">
                {!!Form::open(['route'=>'categoria.store','method'=>'POST'])!!}

                {{ csrf_field() }}

            <div class="box-body">

			    <div class="form-group">
				{{ csrf_field() }}

				{!!Form::label('Nombre', 'Nombre *', array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					{!!Form::text('nombre', null, array('placeholder' => 'Herramientas, Materiales de Limpieza','class' => 'form-control')) !!}
					<div class="error">
						<ul>@foreach($errors->get('nombre') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
			</div>

			<div class="form-group">
				{!!Form::label('Descripción', 'Descripción',  array('class' =>'col-md-2 control-label' )) !!}
				<div class="col-md-7">
					{!!Form::text('descripcion', null, array('placeholder' => 'Material necesario para la limpieza y desinfección de superficies','class' => 'form-control')) !!}
					<div class="error">
						<ul>@foreach($errors->get('descripcion') as $msg)<li>{{$msg}}</li> @endforeach</ul>
					</div>
				</div>
				
			</div>
           
			<div class="form-group">
				<div class="col-md-offset-2 col-md-7">
					<button type="submit" class="btn btn-primary">Guardar</button>
					<a href="{{route('categoria.index')}}" class="btn btn-primary">Cancelar</a>
				</div>
			</div>
			{!! Form::close() !!}
        </div>
			    
        </div>
    </div>
</div>
@endsection
