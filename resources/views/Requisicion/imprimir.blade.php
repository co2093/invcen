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
                    Centro de Investigaciones y Desarrollo en Salud<br>
                    Universidad de El Salvador<br>
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
<table>
    <tr>
        <td>SOLICITUD Nº: {{$fecha['numero']}}</td>
        <td class="text-right">FECHA APROBACI&Oacute;N: {{$fecha['fecha']}}</td>
    </tr>
    <tr>
        <td>ORDEN DE REQUISICI&Oacute;N Nº&nbsp;&nbsp;&nbsp;&nbsp;<label class="red">{{$requisicion->ordenrequisicion}}</label></td>
        <td></td>
    </tr>
    <tr>
        <td><p>UNIDAD/USUARIO SOLICITANTE: {{$requisicion->departamento['name']}}</p></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><i>Sin las firmas y sellos del Usuario, Jefe de la Unidad o equivalente ésta requisición no es válida</i>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td colspan="3">JEFE DE LA UNIDAD O USUARIO SOLICITANTE</td>
    </tr>
    <tr>
        <td style="width: 50%;">NOMBRE: ____________________________________________________
        </td>
        <td style="width: 25%;">
            FIRMA: ______________________
        </td>
        <td style="width: 25%;">
            SELLO:
        </td>
    </tr>
</table>

<div></div>
      <table class="table table-bordered ">
      <thead>
          <tr class="row">
              <th class="col-xs-1" style="width: 10%;"><strong>ESPEC&Iacute;FICO</strong></th>
              <th class="col-xs-1" style="width: 7%;"><strong>C&Oacute;DIGO</strong></th>
              <th class="col-xs-5" style="width: 20%;"><strong>PRODUCTO</strong></th>
              <th class="col-xs-2" style="width: 20%;"><strong>UNIDAD DE MEDIDA</strong></th>
              <th class="col-xs-2" style="width: 10%;"><strong>CANTIDAD SOLICITADA</strong></th>
              <th class="col-xs-2" style="width: 11%;"><strong>CANTIDAD ENTREGADA</strong></th>
              <th class="col-xs-2" style="width: 10%;"><strong>PRECIO UNITARIO</strong></th>
              <th class="col-xs-2" style="width: 12%;"><strong>TOTAL</strong></th>

          </tr>
       </thead>
      <tbody>            
      @foreach ($detalle as $d) 

          <tr>
              <td style="width: 10%;">{{$d->articulo->id_especifico}}</td>
              <td style="width: 7%;">{{$d->articulo->getCodigoArticuloReporte()}}</td>
              <td style="width: 20%;">{{$d->articulo['nombre_articulo']}}</td>
              <td style="width: 20%;">{{$d->articulo['unidad']['nombre_unidadmedida']}}</td>
              <td style="width: 10%;">{{$d->cantidad_solicitada}}</td>
              <td style="width: 11%">{{$d->cantidad_entregada}}</td>
             <td style="width: 10%">${{number_format($d->precio,2,'.','')}}</td>
              <td style="width: 12%">${{number_format($d->getMonto(),2,'.','')}}</td>
          </tr>

      @endforeach
      <tr>
          <td colspan="7" class="text-right">
              <strong>TOTAL PASANTE:</strong>
          </td>
          <td><strong>$ {{number_format($total,2,'.','')}}</strong>
          </td>
      </tr>
      </tbody>  
      </table>
    </div>
    
   <table>
       <tr>
           <td style="width: 60%">Autorizado por : ____________________________________________________________</td>
           <td style="width: 40%">Firma: _______________________</td>
       </tr>

       <tr>
           <td style="width: 60%">Entregado por : ____________________________________________________________</td>
           <td style="width: 40%">Firma: _______________________</td>
       </tr>
       <tr>
           <td style="width: 60%">Recibido por : _____________________________________________________________</td>
           <td style="width: 40%">Firma: _______________________</td>
       </tr>
   </table>


    <div class="row">
      <p>OBSERVACIONES : <ins>{{$requisicion->observacion}}</ins></p>
    </div>





     

 



