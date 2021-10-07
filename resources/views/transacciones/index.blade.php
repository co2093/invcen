@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Kardex</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaDescargo">
            <thead>
            <tr class="info">
                <th colspan="6" class="centrado">Descripci&oacute;n</th>
                <th colspan="3" class="centrado">Saldo inicial</th>
                <th colspan="3" class="centrado">Entrada</th>
                <th colspan="3" class="centrado">Salida</th>
                <th colspan="3" class="centrado">Saldo final</th>
            </tr>

            <tr class="success">
                <th>Nº</th>
                <th>Fecha</th>
                <th>Espec&iacute;fico</th>
                <th>C&oacute;d. Prod</th>
                <th>Producto</th>
                <th>Unidad</th>

                <th>Cantidad</th>
                <th>Costo($)</th>
                <th>Monto($)</th>
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

            @foreach ($transacciones as $transaccion)
                @if($transaccion->ingreso)
                    <tr>
                        <td>{{$transaccion->id_transaccion}}</td>
                        <td>{{$transaccion->getFecha()}}</td>
                        <td>{{$transaccion->articulo->id_especifico}}</td>
                        <td>{{$transaccion->articulo->getCodigoArticuloReporte()}}</td>
                        <td>{{$transaccion->articulo->nombre_articulo}}</td>


                        <td>{{$transaccion->articulo->unidad->nombre_unidadmedida}}</td>

                        <td>{{$transaccion->exis_ant}}</td>
                        <td>{{number_format($transaccion->ingreso->pre_unit_ant,2,'.','')}}</td>
                        <td>{{number_format($transaccion->ingreso->getMontoAnterior(),2,'.','')}}</td>
                        <td>{{$transaccion->cantidad}}</td>
                        <td>{{number_format($transaccion->pre_unit,2,'.','')}}</td>
                        <td>{{number_format($transaccion->ingreso->getMontoIngreso(),2,'.','')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$transaccion->exis_nueva}}</td>
                        <td>{{number_format($transaccion->pre_unit,2,'.','')}}</td>
                        <td>{{number_format($transaccion->ingreso->getMontoNuevo(),2,'.','')}}</td>
                    </tr>
                @elseif($transaccion->descargo)
                    <tr>
                        <td>{{$transaccion->id_transaccion}}</td>
                        <td>{{$transaccion->getFecha()}}</td>
                        <td>{{$transaccion->articulo->id_especifico}}</td>
                        <td>{{$transaccion->articulo->getCodigoArticuloReporte()}}</td>
                        <td class="col-md-2">{{$transaccion->articulo->nombre_articulo}}</td>
                        <td>{{$transaccion->articulo->unidad->nombre_unidadmedida}}</td>
                        <td>{{$transaccion->exis_ant}}</td>
                        <td>{{number_format($transaccion->pre_unit,2,'.','')}}</td>
                        <td>{{number_format($transaccion->descargo->getMontoAnterior(),2,'.','')}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{$transaccion->cantidad}}</td>
                        <td>{{number_format($transaccion->pre_unit,2,'.','')}}</td>
                        <td>{{number_format($transaccion->descargo->getMontoDescargo(),2,'.','')}}</td>
                        <td>{{$transaccion->exis_nueva}}</td>
                        <td>{{number_format($transaccion->pre_unit,2,'.','')}}</td>
                        <td>{{number_format($transaccion->descargo->getMontoNuevo(),2,'.','')}}</td>
                    </tr>
                @endif


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
