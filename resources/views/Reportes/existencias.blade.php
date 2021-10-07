<style>
    table{
        margin-bottom: 15px;
        border-collapse: collapse;
    }

    .table{
        border: 1px solid #b8c7ce;
        border-collapse: collapse;
        margin-top: 10px;
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
        <tr class="row">

            <td class="ancho-l">
                <div class="text-center">
                    <img src="{{asset('dist/img/minerva.jpg')}}" alt="Logo ues" style="width: 5em; height:7em;">
                </div>
            </td>
            <td class="ancho-c">
                <div class="text-center distancia">
                    <strong>
                        Centro de Investigaciones y Desarrollo en Salud<br>
                        Universidad de El Salvador<br>
                        Existencias al {{$fecha}}
                    </strong>
                </div>
            </td>
            <td class="ancho-r">
                <div class="text-center">
                    <img src="{{asset('dist/img/logocensalud.png')}}" alt="logo CENSALUD" style="width: 300px;  ">
                </div>
            </td>
        </tr>
    </table>



        <table class="table">
            <thead>
            <tr class="atributos">
                <th style="width: 8%;"><strong>Espec&iacute;fico</strong></th>
                <th style="width: 8%;"><strong>C&oacute;d. prod.</strong></th>
                <th style="width: 30%;"><strong>Producto</strong></th>
                <th style="width: 20%;"><strong>Unidad de medida</strong></th>
                <th style="width: 8%;"><strong>Existencia</strong></th>
                <th style="width: 12%;"><strong>Precio unitario</strong></th>
                <th style="width: 14%;"><strong>Monto</strong></th>

            </tr>
            </thead>
            <tbody>
            @foreach ($articulos as $a)
                <tr>
                    <td style="width: 8%;">{{$a->id_especifico}}</td>
                    <td style="width: 8%;">{{$a->getCodigoArticuloReporte()}}</td>
                    <td style="width: 30%;">{{$a->nombre_articulo}}</td>
                    <td style="width: 20%;">{{$a->unidad->nombre_unidadmedida}}</td>
                    @if ($a->existencia <= 25 && $color =='veinticinco')
                        <td style="color: red; width: 8%;">{{$a->existencia}}</td>
                    @else
                        <td style="width: 8%;">{{$a->existencia}}</td>
                    @endif
                    <td style="width: 12%;">${{number_format($a->precio_unitario,4,'.','')}}</td>
                    <td style="width: 14%;">${{number_format($a->monto(),4,'.','')}}</td>

                </tr>
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



