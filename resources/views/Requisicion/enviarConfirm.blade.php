@extends('layouts.template')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>¿Esta seguro que desea enviar su solicitud?</strong>
            </h4>
        </div>
        <div class="panel-body">
            <div class="alert">
                <strong>Nota:</strong> Asegurese que su solicitud esté bien elaborada antes de poder enviarla.
            </div>
            <div class="">
                <a href="{{url('requisicion/store')}}" class="btn btn-success">Enviar</a>
                <a class="btn btn-default" href="{{Route('requisicion-show')}}">Cancelar</a>
            </div>
        </div>
    </div>
@endsection


