@extends('layouts.template')

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Eliminar Categoría</strong>
            </h4>
        </div>
        <div class="panel-body">

            @if($especifico)
                <div class="col-md-offset-1">
                    <h4>¿Est&aacute; seguro que desea eliminar la siguiente categoría?</h4>
                </div>
                <dl class="dl-horizontal">
                    <dt>C&oacute;digo:</dt>
                    <dd>{{ $especifico->id}}</dd>

                    <dt>Nombre:</dt>
                    <dd>{{ $especifico->titulo_especifico }}</dd>

                    <dt>Descripci&oacute;n:</dt>
                    <dd>{{ $especifico->descripcion_epecifico }}</dd>
                </dl>

                {!! Form::open(['method' => 'DELETE','route' => ['especifico.destroy', $especifico->id],'style'=>'display:inline']) !!}
                {{ csrf_field() }}
                <div class="col-md-offset-1">
                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                    <a href="{{ route('especifico.index')}}" class="btn btn-primary">Cancelar</a>
                </div>
                {!! Form::close() !!}
        </div>
    </div>

    @endif
@endsection