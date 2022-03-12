@extends('layouts.template')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Nueva unidad de medida</strong>
            </h4>
        </div>
        <div class="panel-body">
            {!! Form::open(array('route' => 'unidad.store','class' => 'form-horizontal','method' => 'post')) !!}

            <div class="form-group">
                {!!Form::label('Unidad de medida', 'Unidad de medida *', array('class' =>'control-label col-md-2' )) !!}
                <div class="col-md-7">
                    {!!Form::textarea('nombre_unidadmedida', null, array('placeholder' => 'Gramo,Litro','class' => 'form-control rounded-0', 'rows' => 50, 'cols' => 50, 'style' => 'resize:both')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('nombre_unidadmedida') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-7">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{route('unidad.index')}}" class="btn btn-primary">Cancelar</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection