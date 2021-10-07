@extends('layouts.template')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>¿Esta seguro que desea aprobar ésta Solicitud?</strong>
            </h4>
        </div>
        <div class="panel-body">
            <div class="alert">
                <strong>Nota:</strong> Asegurese que la solicitud que usted va a aprobar
                sea la correcta, sino puede volver a editarla.
            </div>
            <div class="">
                <a href="{{route('requisicion-trash')}}" class="btn btn-success">Vaciar</a>
                <a class="btn btn-default" href="{{Route('requisicion-show')}}">Cancelar</a>
            </div>
        </div>
    </div>
@endsection
