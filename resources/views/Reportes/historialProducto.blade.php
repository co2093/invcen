
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
        padding: 1px !important;
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
                   <img src="dist/img/minerva.jpg" alt="Logo ues" style="width: 7em; height:9em;">
                </div>
            </td>
            <td class="ancho-c">
                <div class="text-center distancia">
                    <strong>
                        Centro de Investigaciones y Desarrollo en Salud<br>
                        Universidad de El Salvador<br>
                        Historial de producto<br>
                        Del {{$desde}} al {{$hasta}}
                    </strong>
                </div>
            </td>
            <td class="ancho-r">
                <div class="text-center">
                  <img src="dist/img/logocensalud.png" alt="logo CENSALUD" style="width: 300px; ">
                </div>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>
                <div class="text-center">
                    ESPEC&Iacute;FICO:<strong>{{$articulo->id_especifico}}</strong>
                </div>

            </td>
            <td>
                <div class="text-center">
                C&Oacute;DIGO:<strong>{{$articulo->getCodigoArticuloReporte()}}</strong>
                </div>

            </td>
            <td>
                <div class="text-center">

                ART&Iacute;CULO: <strong>{{$articulo->nombre_articulo}}
                    </strong>
                </div>
            </td>
            <td>
                <div class="text-center">

                UNIDAD DE MEDIDA: <strong>{{$articulo->unidad->nombre_unidadmedida}}</strong>
                </div>
            </td>

        </tr>
    </table>




    <table class="table">
        <thead>
        <tr class="des-general">
            <th colspan="4" class="centrado" style="width: 43%;"><strong>Descripci&oacute;n</strong></th>
            <th colspan="2" class="centrado" style="width: 12%;"><strong>Saldo inicial</strong></th>
            <th colspan="2" class="centrado" style="width: 12%;"><strong>Entrada</strong></th>
            <th colspan="2" class="centrado" style="width: 12%;"><strong>Salida</strong></th>
            <th colspan="3" class="centrado" style="width: 21%;"><strong>Saldo final</strong></th>
        </tr>

        <tr class="atributos">

            <th style="width: 7%;"><strong>Fecha</strong></th>
            <th style="width: 8%;"><strong>Requisici&oacute;n</strong></th>
            <th style="width: 8%;"><strong>Procedencia</strong></th>

            <th style="width: 20%;"><strong>Destino</strong></th>
            <th style="width: 4%;"><strong>Cant.</strong></th>

            <th style="width: 8%;"><strong>Costo($)</strong></th>

            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 8%;"><strong>Costo($)</strong></th>

            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 8%;"><strong>Costo($)</strong></th>

            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 8%;"><strong>Costo($)</strong></th>
            <th style="width: 9%;"><strong>Monto($)</strong></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($transacciones as $transaccion)
            @if($transaccion->ingreso)
                <tr>

                    <td style="width: 7%;">{{$transaccion->getFecha()}}</td>
                    <td style="width: 8%;"></td>
                    <td style="width: 8%;">INVENTARIO</td>

                    <td style="width: 20%;"></td>
                    <td style="width: 4%;">{{$transaccion->exis_ant}}</td>
                    <td style="width: 8%;">{{number_format($transaccion->ingreso->pre_unit_ant,4,'.','')}}</td>

                    <td style="width: 4%;">{{$transaccion->cantidad}}</td>
                    <td style="width: 8%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>

                    <td style="width: 4%;"></td>
                    <td style="width: 8%;"></td>
                    <td style="width: 4%;">{{$transaccion->exis_nueva}}</td>
                    <td style="width: 8%;">{{number_format($transaccion->ingreso->pre_unit_nuevo,4,'.','')}}</td>
                    <td style="width: 9%;">{{number_format($transaccion->ingreso->getMontoNuevo(),4,'.','')}}</td>
                </tr>
            @elseif($transaccion->descargo)
                <tr>

                    <td style="width: 7%;">{{$transaccion->getFecha()}}</td>
                    <td style="width: 8%;">{{$transaccion->descargo->detalle->requisicion->getNumero()}}</td>
                    <td style="width: 8%;"></td>

                    <td style="width: 20%;">{{$transaccion->descargo->detalle->requisicion->departamento->name}}</td>

                    <td style="width: 4%;">{{$transaccion->exis_ant}}</td>
                    <td style="width: 8%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>
                    <td style="width: 4%;"></td>
                    <td style="width: 8%;"></td>
                    <td style="width: 4%;">{{$transaccion->cantidad}}</td>
                    <td style="width: 8%;">{{number_format($transaccion->pre_unit,4,'.','')}}</td>

                    <td style="width: 4%;">{{$transaccion->exis_nueva}}</td>

                    <td style="width: 8%;">{{number_format($transaccion->descargo->pre_unit_nuevo,4,'.','')}}</td>

                    <td style="width: 9%;">{{number_format($transaccion->descargo->getMontoNuevo(),4,'.','')}}</td>
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
                    <p><strong>ADMINISTRADOR FINANCIERO</strong></p>
                </div>
            </td>

        </tr>

    </table>




