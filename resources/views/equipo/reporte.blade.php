<style>
    table{
        margin-bottom: 5px;
        border-collapse: collapse;
    }

    .red{
        color: red;
        font-size: 16px;
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

    .text-right{
        text-align: right;
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
        width: 60%;
    }
    .ancho-l{
        width: 15%;
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
                <img src="{{asset('dist/img/minerva.jpg')}}" alt="Logo ues" style="width: 6em; height:8em;">
            </div>
        </td>
        <td class="ancho-c">
            <div class="text-center distancia">
                <strong>
                    REPORTE DE EQUIPOS<br>
                    {{$fecha}} <br>
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


          <!-- <hr style="border: 1px ; border-top: 5px double #C0C0C0;"> -->
          <hr style="border: 0; height: 2px; border-top: 1px solid #C0C0C0; border-bottom: 1px solid #C0C0C0;">

<div></div>
<table class="table table-bordered ">
  <thead>
    <tr class="row">
        <th class="col-xs-3"><strong>TIPO</strong></th>
        <th class="col-xs-2"><strong>NÚMERO INVENTARIO</strong></th>
        <th class="col-xs-4"><strong>RESPONSABLE</strong></th>
        <th class="col-xs-3"><strong>ESTADO</strong></th>
    </tr>
  </thead>
  <tbody>
    @foreach($equipos as $equipo)            
      <tr>
        <td>{{$equipo->tipo['nombre_tipo_equipo']}}</td>          
        <td>{{$equipo->numero_inventario}}</td>
        <td>{{$equipo->responsable}}</td>
        <td>{{$equipo->status['estado']}}</td>
      </tr>
    @endforeach
  </tbody>  
</table>

