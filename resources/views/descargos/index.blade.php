@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Descargos</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaDescargo">
            <thead>
            <tr class="info">
                <th colspan="7" class="centrado">Descripci&oacute;n</th>
                <th colspan="3" class="centrado">Saldo inicial</th>
                <th colspan="3" class="centrado">Salida</th>
                <th colspan="3" class="centrado">Saldo final</th>

            </tr>

            <tr class="success">
                <th>Nº</th>
                <th>Fecha</th>
                <th>Especif&iacute;co</th>
                <th>Cod. Prod.</th>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Requisici&oacute;n</th>
                <th>Cantidad</th>
                <th>Costo($)</th>
                <th>Monto($)</th>
                <th>Cantidad</th>
                <th>Costo($)</th>
                <th>Monto($)</th>
                <th>Cantidad</th>
                <th>Costo($)</th>
                <th>Monto($)</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($descargos as $descargo)

                <tr>

                    <td>{{$descargo->id_descargo}}</td>
                    <td>{{$descargo->transaccion->getFecha()}}</td>
                    <td>{{$descargo->transaccion->articulo->id_especifico}}</td>
                    <td>{{$descargo->transaccion->articulo->getCodigoArticuloReporte()}}</td>
                    <td>{{$descargo->transaccion->articulo->nombre_articulo}}</td>

                    <td>{{$descargo->transaccion->articulo->unidad->nombre_unidadmedida}}</td>
                    <td>{{$descargo->detalle->requisicion->getNumero()}}</td>

                    <td>{{$descargo->transaccion->exis_ant}}</td>
                    <td>{{number_format($descargo->transaccion->pre_unit,2,'.','')}}</td>
                    <td>{{number_format($descargo->getMontoAnterior(),2,'.','')}}</td>
                    <td>{{$descargo->transaccion->cantidad}}</td>
                    <td>{{number_format($descargo->transaccion->pre_unit,2,'.','')}}</td>
                    <td>{{number_format($descargo->getMontoDescargo(),2,'.','')}}</td>
                    <td>{{$descargo->transaccion->exis_nueva}}</td>
                    <td>{{number_format($descargo->transaccion->pre_unit,2,'.','')}}</td>
                    <td>{{number_format($descargo->getMontoNuevo(),2,'.','')}}</td>

                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#TablaDescargo').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false,
                });
        });


    </script>
@endsection
