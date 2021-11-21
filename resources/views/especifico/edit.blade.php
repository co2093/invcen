@extends('layouts.template')
@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Editar Categoría</strong>
            </h4>
        </div>
        <div class="panel-body">

            @if($especifico)
                {!! Form::open(array('route' => ['especifico.update','id' => $especifico->id],'class' => 'form-horizontal','method' => 'put')) !!}
                {{ csrf_field() }}
                <div class="form-group">
                    {!!Form::label('Especifico', 'Especifico', array('class' =>'control-label col-md-2' )) !!}
                    <div class="col-md-7">
                        {!!Form::text('numero', $especifico->id, array('placeholder' => '1234','class' => 'form-control','disabled')) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('numero') as $msg)
                                    <li>{{$msg}}</li> @endforeach</ul>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('Titulo', 'Nombre *', array('class' =>'control-label col-md-2' )) !!}
                    <div class="col-md-7">
                        {!!Form::text('titulo', $especifico->titulo_especifico, array('placeholder' => 'Quimicos','class' => 'form-control')) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('titulo') as $msg)
                                    <li>{{$msg}}</li> @endforeach</ul>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!!Form::label('Descripcion', 'Descripcion', array('class' =>'control-label col-md-2' )) !!}
                    <div class="col-md-7">
                        {!!Form::textarea('descripcion',$especifico->descripcion_epecifico, array('class' => 'form-control')) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('descripcion') as $msg)
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
        </div>
    </div>

    @endif
@endsection