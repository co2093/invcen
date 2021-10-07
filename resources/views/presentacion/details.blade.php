@extends('layouts.template')

@section('content')

    <div class="col-md-offset-1">
        <h3>Detalle</h3>
    </div>
    <hr/>
    @if($especifico)

        <dl class="dl-horizontal">
            <dt>Numero:</dt>
            <dd>{{ $especifico->id}}</dd>

            <dt>Titulo:</dt>
            <dd>{{ $especifico->titulo_especifico }}</dd>

            <dt>Descripcion:</dt>
            <dd>{{ $especifico->descripcion_epecifico }}</dd>
        </dl>
        <div class="alert alert-info">
            Articulos que pertenecen a este especifico<br/>
            @foreach($especifico->articulo as $art)
                {{$art->nombre_articulo}}<br/>
            @endforeach
        </div>

        <div class="col-md-offset-1">
            <a href="{{ route('especifico.index')}}" class="btn btn-primary">Vover a la lista</a>
        </div>
    @endif

@endsection