@extends('layouts.template')
@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Editar unidad de medida</strong>
            </h4>
        </div>
        <div class="panel-body">

            @if($unidad)
                {!! Form::open(array('route' => ['unidad.update','id_unidad_medida' => $unidad->id_unidad_medida],'class' => 'form-horizontal','method' => 'put')) !!}

                <div class="form-group">
                    {!! Form::label('Unidad de medida', 'Unidad de medida *', array('class' =>'control-label col-md-2' )) !!}
                    <div class="col-md-7">
                        {!!Form::textarea('nombre_unidadmedida', $unidad->nombre_unidadmedida, ['class' => 'form-control rounded-0', 'rows' => 50, 'cols' => 50, 'style' => 'resize:both']) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('nombre_unidadmedida') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-7">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{route('unidad.index')}}" class="btn btn-primary">Cancelar</a>
                    </div>
                </div>

                {!! Form::close() !!}
        </div>
    </div>
    @endif

@endsection