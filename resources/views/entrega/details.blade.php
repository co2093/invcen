
@extends('layouts.template')

@section('content')

    <a href="javascript:window.history.back();" class="btn btn-default margen"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Detalle de entrega</strong>
            </h4>
        </div>
        <div class="panel-body">
            <strong>Solicitante:</strong> {{ $entrega[0]->solicitante }}<br>

            <strong>Fecha de entrega: </strong>{{ $entrega[0]->fechaentrega }}<br>

            <div>
                <strong>Descripci&oacute;n:</strong><p> {{ $entrega[0]->descripcion}}</p>
            </div>

        </div>
    </div>




    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaDetalleRequesicion">
            <caption><strong>Productos entregados: </strong></caption>
            <thead>
            <tr class="success">
                <th>Producto</th>
                <th>Unidad de medida</th>
                <th>Cantidad entregada</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($entregas as $de)
                <tr>
                    <td>{{$de->nombre_articulo}}</td>
                    <td>{{$de->nombre_unidadmedida}}</td>
                    <td>{{$de->cantidadentregada}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $("#TablaDetalleRequesicion").DataTable(
                {
                    "lengthChange": false,
                    "searching": false,
                    "info": false,
                });
        });


    </script>
@endsection
