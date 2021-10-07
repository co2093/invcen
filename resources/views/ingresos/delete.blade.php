@extends('layouts.template')

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h2 class="panel-title">
                <strong>Eliminar entrada</strong>
            </h2>
        </div>
        <div class="panel-body">

            @if($ingreso)
                <div class="col-md-offset-1">
                    <h4>Esta seguro que desea eliminar la siguiente entrada?</h4>
                </div>
                <dl class="dl-horizontal">
                    <dt>Numero:</dt>
                    <dd>{{ $ingreso->id_ingreso}}</dd>

                    <dt>Fecha:</dt>
                    <dd>{{ $ingreso->transaccion->getFecha()}}</dd>
                    <dt>Articulo:</dt>
                    <dd>{{ $ingreso->transaccion->articulo->nombre_articulo}}</dd>
                    <dt>Unidad:</dt>
                    <dd>{{ $ingreso->transaccion->articulo->unidad->nombre_unidadmedida}}</dd>
                    <dt>Cantidad:</dt>
                    <dd>{{ $ingreso->transaccion->cantidad}}</dd>
                    <dt>Precio unitario:</dt>
                    <dd>${{number_format($ingreso->transaccion->pre_unit,2,'.','') }}</dd>
                    <hr/>
                    <div class="col-md-offset-1">
                        <h4>Existencia anterior</h4>
                    </div>
                    <dt>Existencia:</dt>
                    <dd>{{ $ingreso->transaccion->exis_ant}}</dd>
                    <dt>Precio unitario:</dt>
                    <dd>${{number_format($ingreso->pre_unit_ant,2,'.','') }}</dd>
                    <div class="col-md-offset-1">
                        <h4>Existencia Posterior</h4>
                    </div>
                    <dt>Existencia:</dt>
                    <dd>{{ $ingreso->transaccion->exis_nueva}}</dd>
                    <dt>Precio unitario:</dt>
                    <dd>${{number_format($ingreso->pre_unit_nuevo,2,'.','') }}</dd>


                </dl>
                {!! Form::open(['method' => 'DELETE','route' => ['ingreso.destroy', $ingreso->id_ingreso],'style'=>'display:inline']) !!}

                {{ csrf_field() }}
                <div class="col-md-offset-1">
                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                    <a href="{{ route('ingreso.index')}}" class="btn btn-primary">Cancelar</a>
                </div>
                {!! Form::close() !!}

            @endif
        </div>
    </div>
@endsection
