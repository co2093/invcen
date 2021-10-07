@extends('layouts.template')
@section('content')

    <div class="col-md-offset-2">
        <h3>Editar</h3>
    </div>
    <hr/>
    @if($presentacion)
        {!! Form::open(array('route' => ['presentacion.update','id' => $presentacion->id_pres],'class' => 'form-horizontal','method' => 'put')) !!}
        {{ csrf_field() }}

        <div class="form-group">
            {!!Form::label('Presentacion', 'Presentacion', array('class' =>'control-label col-md-2' )) !!}
            <div class="col-md-7">
                {!!Form::text('presentacion', $presentacion->presentacion, array('placeholder' => 'Galon de pintura roja','class' => 'form-control')) !!}
                <div class="error">
                    <ul>@foreach($errors->get('presentacion') as $msg)
                            <li>{{$msg}}</li> @endforeach</ul>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-offset-2 col-md-7">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('especifico.index')}}" class="btn btn-primary">Cancelar</a>
            </div>
        </div>

        {!! Form::close() !!}

    @endif
@endsection