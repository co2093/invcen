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
                  <img src="dist/img/minerva.jpg" alt="Logo ues" style="width: 5em; height:7em;">
                </div>
            </td>
            <td class="ancho-c">
                <div class="text-center distancia">
                    <strong>
                       CENTRO DE INVESTIGACIÓN Y DESARROLLO EN SALUD "CENSALUD"<br>
                    Universidad de El Salvador<br>
                        Reporte de proveedores
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
            <tr class="atributos">
                <th style="width: 25%;"><strong>Nombre</strong></th>
                <th style="width: 25%;"><strong>Dirección</strong></th>
                <th style="width: 10%;"><strong>Teléfono</strong></th>
                <th style="width: 10%;"><strong>Fax</strong></th>
                <th style="width: 15%;"><strong>Email</strong></th>
                <th style="width: 15%;"><strong>Vendedor</strong></th>

            </tr>
            <tbody>
            @foreach ($proveedores as $a)
                <tr>
                    <td style="width: 25%;">{{$a->nombre}}</td>
                    <td style="width: 25%;">{{$a->direccion}}</td>
                    <td style="width: 10%;">{{$a->telefono}}</td>
                    <td style="width: 10%;">{{$a->fax}}</td>
                    <td style="width: 15%;">{{$a->email}}</td>
                    <td style="width: 15%;">{{$a->vendedor}}</td>

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



