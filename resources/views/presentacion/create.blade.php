@extends('layouts.template')

@section('content')

    <div class="col-md-offset-2">
        <h3>Nueva Presentacio</h3>
    </div>
    <hr/>

    {!! Form::open(array('route' => 'presentacion.store','class' => 'form-horizontal','method' => 'post')) !!}

    {{ csrf_field() }}

    <div class="form-group">
        {!!Form::label('Presentacion', 'Presentacion', array('class' =>'control-label col-md-2' )) !!}
        <div class="col-md-7">
            {!!Form::text('presentacion', null, array('placeholder' => 'Galon de pintura roja','class' => 'form-control')) !!}
            <div class="error">
                <ul>@foreach($errors->get('presentacion') as $msg)
                        <li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-2 col-md-7">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('presentacion.index')}}" class="btn btn-primary">Cancelar</a>
        </div>
    </div>

    {!! Form::close() !!}

@endsection