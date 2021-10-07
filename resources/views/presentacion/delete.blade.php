@extends('layouts.template')

@section('content')

    <div class="col-md-offset-1">
        <h3>Eliminar Presentacion</h3>
    </div>
    <hr/>
    @if($presentacion)
        <div class="col-md-offset-1">
            <h4>Esta seguro que desea eliminar la siguiente presentacion?</h4>
        </div>
        <dl class="dl-horizontal">
            <dt>Presentacion:</dt>
            <dd>{{ $presentacion->presentacion}}</dd>

        </dl>

        {!! Form::open(['method' => 'DELETE','route' => ['presentacion.destroy', $presentacion->id_pres],'style'=>'display:inline']) !!}
        {{ csrf_field() }}

        <div class="col-md-offset-1">
            {!! Form::submit('Delete', ['class' => 'btn btn-primary']) !!}
            <a href="{{ route('presentacion.index')}}" class="btn btn-primary">Cancelar</a>
        </div>
        {!! Form::close() !!}

    @endif
@endsection