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
                   <img src="dist/img/minerva.jpg" alt="Logo ues" style="width: 8em; height:10em;">
                </div>
            </td>
            <td class="ancho-c">
                <div class="distancia text-center">
                    <strong>
                        CENTRO DE INVESTIGACIÓN Y DESARROLLO EN SALUD "CENSALUD"<br>
                    Universidad de El Salvador<br>
                        Consolidado de existencias<br>
                        Del {{$desde}} al {{$hasta}}
                    </strong>
                </div>
            </td>
            <td class="ancho-r">
                <div class="text-center">
                 <img src="dist/img/logocensalud.png" alt="logo CENSALUD" style="width: 300px;  ">
                </div>
            </td>
        </tr>
    </table>


    <table class="table">
        <thead>
        <tr class="des-general">
            <th colspan="4" class="centrado" style="width: 33%;"><strong>Descripci&oacute;n</strong></th>
            <th colspan="3" class="centrado" style="width: 16%;"><strong>Saldo inicial</strong></th>
            <th colspan="3" class="centrado" style="width: 16%;"><strong>Entrada</strong></th>
            <th colspan="3" class="centrado" style="width: 16%;"><strong>Salida</strong></th>
            <th colspan="3" class="centrado" style="width: 19%;"><strong>Saldo final</strong></th>
        </tr>

        <tr class="atributos">
            <th style="width: 3%;"><strong>Esp.</strong></th>
            <th style="width: 3%;"><strong>C&oacute;d prod.</strong></th>
            <th style="width: 15%;"><strong>Producto</strong></th>
            <th style="width: 12%;"><strong>Unidad</strong></th>

            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 5%;"><strong>Costo($)</strong></th>
            <th style="width: 7%;"><strong>Monto($)</strong></th>
            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 5%;"><strong>Costo($)</strong></th>
            <th style="width: 7%;"><strong>Monto($)</strong></th>
            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 5%;"><strong>Costo($)</strong></th>
            <th style="width: 7%;"><strong>Monto($)</strong></th>
            <th style="width: 4%;"><strong>Cant.</strong></th>
            <th style="width: 5%;"><strong>Costo($)</strong></th>
            <th style="width: 10%;"><strong>Monto($)</strong></th>
        </tr>
        </thead>
        <tbody>

        @foreach ($transacciones as $transaccion)
            @if($transaccion['especifico']=='r')
            <tr>
                <td style="width: 3%;"></td>
                <td style="width: 3%;"></td>
                <td style="width: 15%;"></td>
                <td style="width: 12%;"></td>

                <td style="width: 4%;"><strong>{{$transaccion['cantidadi']}}</strong></td>
                <td style="width: 5%;"><strong>{{$transaccion['precioi']}}</strong></td>
                <td style="width: 7%;"><strong>{{$transaccion['montoi']}}</strong></td>
                <td style="width: 4%;"><strong>{{$transaccion['cantidade']}}</strong></td>
                <td style="width: 5%;"><strong>{{ $transaccion['precioe'] }}</strong></td>
                <td style="width: 7%;"><strong>{{$transaccion['montoe']}}</strong></td>

                <td style="width: 4%;"><strong>{{$transaccion['cantidads']}}</strong></td>
                <td style="width: 5%;"><strong>{{$transaccion['precios']}}</strong></td>
                <td style="width: 7%;"><strong>{{$transaccion['montos']}}</strong></td>

                <td style="width: 4%;"><strong>{{$transaccion['cantidadf']}}</strong></td>
                <td style="width: 5%;"><strong>{{$transaccion['preciof']}}</strong></td>
                <td style="width: 10%;"><strong>{{$transaccion['montof']}}</strong></td>
            </tr>
            @else
                <tr>
                    <td style="width: 3%;">{{$transaccion['especifico']}}</td>
                    <td style="width: 3%;">{{$transaccion['codigo']}}</td>
                    <td style="width: 15%;">{{$transaccion['articulo']}}</td>
                    <td style="width: 12%;">{{$transaccion['unidad']}}</td>

                    <td style="width: 4%;">{{$transaccion['cantidadi']}}</td>
                    <td style="width: 5%;">{{$transaccion['precioi']}}</td>
                    <td style="width: 7%;">{{$transaccion['montoi']}}</td>
                    <td style="width: 4%;">{{$transaccion['cantidade']}}</td>
                    <td style="width: 5%;">{{ $transaccion['precioe'] }}</td>
                    <td style="width: 7%;">{{$transaccion['montoe']}}</td>

                    <td style="width: 4%;">{{$transaccion['cantidads']}}</td>
                    <td style="width: 5%;">{{$transaccion['precios']}}</td>
                    <td style="width: 7%;">{{$transaccion['montos']}}</td>

                    <td style="width: 4%;">{{$transaccion['cantidadf']}}</td>
                    <td style="width: 5%;">{{$transaccion['preciof']}}</td>
                    <td style="width: 10%;">{{$transaccion['montof']}}</td>
                </tr>
                @endif
        @endforeach

        </tbody>
    </table>



    <table>
        <tr nobr="true">

            <td class="pad col-md-3">
                <div class="text-left">
                    <p><strong>FIRMA: ________________________</strong></p>
                    <p><strong>ADMINISTRADOR DE BODEGA</strong></p>
                </div>
            </td>
            <td class="col-md-3">
                <div class="text-left">
                    <p><strong>FIRMA: ________________________</strong></p>
                    <p><strong>ADMINISTRADOR FINANCIERO</strong></p>
                </div>
            </td>

        </tr>
    </table>





