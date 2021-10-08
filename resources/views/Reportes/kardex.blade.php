<style>
    table{
        margin-bottom: 15px;
        border-collapse: collapse;
    }

    .table{
        border: 1px solid #b8c7ce;
        border-collapse: collapse;
    }

    .table > tr > th,
    .table > tr > td,
    .table > thead > tr >td,
    .table > tbody > tr > td{
        padding: 10px !important;
        border: 1px solid #b8c7ce;

    }
    .text-center{
        text-align: center;
    }

    .encabezado{
        font-size: 14px;
    }

    .distancia{
        font-size: 15px;
        margin-bottom: 0px;
        margin-top: 0px;
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .ancho-c{
        width: 50%;
    }
    .ancho-l{
        width: 25%;
    }
    .ancho-r{
        width: 25%;
    }
    img{
        background-color: yellow;
    }
    .des-general{
        background-color: #afd9ee;
        font-size: 12px;
    }
    .atributos{
        background-color: lightgreen;
    }

    .firma{
        margin-left: 30px;
    }

</style>


<table>
    <tr>
        <td class="ancho-l pad">
            <div class="text-center">
              <!--
                <img src="{{asset('dist/img/minerva.jpg')}}" alt="Logo ues" style="width: 8em; height:10em;">
            -->
            </div>
        </td>
        <td class="ancho-c">
            <div class="text-center distancia">
                <strong>
                    Centro de Investigaciones y Desarrollo en Salud<br>
                    Universidad de El Salvador<br>
                    Kardex<br>
                    Del {{$desde}} al {{$hasta}}
                </strong>
            </div>
        </td>
        <td class="ancho-r">
            <div class="text-center">
            <!--

                <img src="{{asset('dist/img/logocensalud.png')}}" alt="logo CENSALUD" style="width: 300px;">
            -->
            
            
            </div>
        </td>
    </tr>
</table>



        <table class="table">
            <thead>
            <tr class="des-general">
                <th colspan="6" class="centrado" style="width: 42%;"><strong>Descripci&oacute;n</strong></th>
                <th colspan="3" class="centrado" style="width: 14%;"><strong>Saldo inicial</strong></th>
                <th colspan="3" class="centrado" style="width: 14%;"><strong>Entrada</strong></th>
                <th colspan="3" class="centrado" style="width: 14%;"><strong>Salida</strong></th>
                <th colspan="3" class="centrado" style="width: 16%;"><strong>Saldo final</strong></th>
            </tr>

            <tr class="atributos">
                <th style="width: 6%;"><strong>Nº</strong></th>
                <th style="width: 5%;"><strong>Fecha</strong></th>
                <th style="width: 3%;"><strong>Esp.</strong></th>
                <th style="width: 3%;"><strong>C&oacute;d prod.</strong></th>
                <th style="width: 15%;"><strong>Producto</strong></th>
                <th style="width: 10%;"><strong>Unidad</strong></th>
                <th style="width: 3%;"><strong>Cant.</strong></th>
                <th style="width: 5%;"><strong>Costo($)</strong></th>
                <th style="width: 6%;"><strong>Monto($)</strong></th>
                <th style="width: 3%;"><strong>Cant.</strong></th>
                <th style="width: 5%;"><strong>Costo($)</strong></th>
                <th style="width: 6%;"><strong>Monto($)</strong></th>
                <th style="width: 3%;"><strong>Cant.</strong></th>
                <th style="width: 5%;"><strong>Costo($)</strong></th>
                <th style="width: 6%;"><strong>Monto($)</strong></th>
                <th style="width: 3%;"><strong>Cant.</strong></th>
                <th style="width: 5%;"><strong>Costo($)</strong></th>
                <th style="width: 8%;"><strong>Monto($)</strong></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($transacciones as $transaccion)
                @if($transaccion->ingreso)
                    <tr>
                        <td style="width: 6%;">{{$transaccion->id_transaccion}}</td>
                        <td style="width: 5%;">{{$transaccion->getFecha()}}</td>
                        <td style="width: 3%;">{{$transaccion->articulo->id_especifico}}</td>
                        <td style="width: 3%;">{{$transaccion->articulo->getCodigoArticuloReporte()}}</td>
                        <td style="width: 15%;">{{$transaccion->articulo->nombre_articulo}}</td>
                        <td style="width: 10%;">{{$transaccion->articulo->unidad->nombre_unidadmedida}}</td>

                        <td style="width: 3%;">{{$transaccion->exis_ant}}</td>
                        <td style="width: 5%;">{{number_format($transaccion->ingreso->pre_unit_ant,4,'.','')}}</td>
                        <td style="width: 6%;">{{number_format($transaccion->ingreso->getMontoAnterior(),4,'.','')}}</td>
                        <td style="width: 3%;">{{$transaccion->cantidad}}</td>
                        <td style="width: 5%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>
                        <td style="width: 6%;">{{number_format($transaccion->ingreso->getMontoIngreso(),4,'.','')}}</td>
                        <td style="width: 3%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 6%;"></td>
                        <td style="width: 3%;">{{$transaccion->exis_nueva}}</td>
                        <td style="width: 5%;">{{number_format($transaccion->ingreso->pre_unit_nuevo,4,'.','')}}</td>
                        <td style="width: 8%;">{{number_format($transaccion->ingreso->getMontoNuevo(),4,'.','')}}</td>
                    </tr>
                @elseif($transaccion->descargo)
                    <tr>
                        <td style="width: 6%;">{{$transaccion->id_transaccion}}</td>
                        <td style="width: 5%;">{{$transaccion->getFecha()}}</td>
                        <td style="width: 3%;">{{$transaccion->articulo->id_especifico}}</td>
                        <td style="width: 3%;">{{$transaccion->articulo->getCodigoArticuloReporte()}}</td>

                        <td style="width: 15%;">{{$transaccion->articulo->nombre_articulo}}</td>
                        <td style="width: 10%;">{{$transaccion->articulo->unidad->nombre_unidadmedida}}</td>

                        <td style="width: 3%;">{{$transaccion->exis_ant}}</td>
                        <td style="width: 5%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>
                        <td style="width: 6%;">{{number_format($transaccion->descargo->getMontoAnterior(),4,'.','')}}</td>
                        <td style="width: 3%;"></td>
                        <td style="width: 5%;"></td>
                        <td style="width: 6%;"></td>
                        <td style="width: 3%;">{{$transaccion->cantidad}}</td>
                        <td style="width: 5%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>
                        <td style="width: 6%;">{{number_format($transaccion->descargo->getMontoDescargo(),4,'.','')}}</td>
                        <td style="width: 3%;">{{$transaccion->exis_nueva}}</td>

                        <td style="width: 5%;">{{number_format($transaccion->descargo->pre_unit_nuevo,4,'.','')}}
                        </td>

                        <td style="width: 8%;">{{number_format($transaccion->descargo->getMontoNuevo(),4,'.','')}}</td>
                    </tr>
                @endif


            @endforeach

            </tbody>
        </table>



    <table>
        <tr nobr="true">
            <td>
                <div class="text-left">
                    <p><strong>FIRMA: ________________________</strong></p>
                    <p><strong>ADMINISTRADOR DE BODEGA</strong></p>
                </div>
            </td>
            <td>
                <div class="text-left">
                    <p><strong>FIRMA: ________________________</strong></p>
                    <div class="firma"><strong>ADMINISTRADOR FINANCIERO</strong></div>
                </div>
            </td>

        </tr>

    </table>





