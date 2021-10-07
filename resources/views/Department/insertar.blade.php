@extends('layouts.template')

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Nuevo Usuario/Unidad</strong>
            </h4>
        </div>
        <div class="panel-body">

            {!! Form::open(array('route' => 'departamento.store','class' => 'form-horizontal','autocomplete'=>'off','method' => 'post')) !!}
            {{ csrf_field() }}

            <div class="form-group">
                {!!Form::label('Nombre', 'Nombre *', array('class' =>'control-label col-md-2' )) !!}
                <div class="col-md-7">
                    {!!Form::text('name', null, array('placeholder' => 'Nombre','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('name') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!!Form::label('Descripcion', 'Descripcion*', array('class' =>'control-label col-md-2' )) !!}
                <div class="col-md-7">
                    {!!Form::text('descripcion', null, array('placeholder' => 'Descripcion','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('descripcion') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-7">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="javascript:window.history.back();" class="btn btn-primary">Cancelar</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection