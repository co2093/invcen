@extends('layouts.template')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>¿Esta seguro que desea vaciar su solicitud?</strong>
            </h4>
        </div>
        <div class="panel-body">
            <div class="alert">
                <strong>Nota:</strong> Esta opci&oacute;n le permitir&aacute; vaciar su solicitud,
                eliminandole todos los productos que usted hab&iacute;a agregado, para que usted pueda volver
                a realizar su solicitud desde cero.
            </div>
            <div class="">
                <a href="{{route('requisicion-trash')}}" class="btn btn-success">Vaciar</a>
                <a class="btn btn-default" href="{{Route('requisicion-show')}}">Cancelar</a>
            </div>
        </div>
    </div>
@endsection
