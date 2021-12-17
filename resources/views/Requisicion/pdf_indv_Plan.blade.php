<style>
      table{
        margin-bottom: 15px;
        border-collapse: collapse;
    }
    .table{
        border: 1px solid #000000;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table > tr > th
    .table > tr > td,
    .table > thead > tr >td,
    .table > tbody > tr > td{
        padding: 10px !important;
        border: 1px solid #000000;
    }

    .encabezado{
        font-size: 14px;
    } 
    h3{
        font-family: 'Akrux W05 Light';
        text-align: left;
    }
    
    .distancia{
        font-size: 15px;
        margin-bottom: 0px;
        margin-top: 0px;
        padding-top: 0px;
        padding-bottom: 0px;
    }
    .t2{
        font-family: 'Montserrat', sans-serif;
        color: #34142c;
    }
    h1{
        text-decoration: underline;
        text-decoration-color: #5f2434;
    }
    .titulo{
        font-family: 'Montserrat', sans-serif;
        font-size: 15px;
        font-weight: bold;
        color: #ca343c;
    }
    .ancho-c{
        width: -25%;
    }
    .ancho-l{
        width: 25%;
    }
    .ancho-r{
        width: 25%;
    }

    .atributos{
        background-color: #cecbcd;
    }


</style>

<table>
    <tr class="row">
        <td class="ancho-l pad">
            <div class="text-center">
                <img src="dist/img/LOGOnewcensalud.jpg" alt="Logo ues" style="width: 300px;">
            </div>
        </td>
        <td class="ancho-c">
            <div class="text-center distancia">
                <strong class="t2">
                    <h1><i>Centro de Investigaciones y Desarrollo en Salud</i></h1>
                    <h4 class="titulo">Universidad de El Salvador</h4><br>
                    <br>
                </strong>
            </div>
            
        </td>
    </tr>
    
</table>

    <h3>Solicitudes de: <i style="color: #34142c">{{$requisicion->departamento['name']}}</i></h3>
    <h3>Fecha de Solicitud: <strong style="color: #5f2434">{{$requisicion->getFechaSolicitud()}}</strong></h3>
    <h3>Orden requisici&oacute;n nº: <strong style="color: #5f2434">{{$requisicion->ordenrequisicion}}</strong></h3>
    <h3>Solicitud: <strong style="color: #5f2434">{{$requisicion->getNumero()}}</strong></h3>

<table class="table">
    <thead>
        <tr>
            <th style="width: 15%;"><strong style="color: #000000">Espec&iacute;fico</strong></th>
            <th style="width: 15%;"><strong style="color: #000000">C&oacute;d. prod</strong></th>
            <th style="width: 30%;"><strong style="color: #000000">Nombre del producto</strong></th>
            <th style="width: 15%;"><strong style="color: #000000">Unidad de Medida</strong></th>
            <th style="width: 10%;"><strong style="color: #000000">Cant. solic.</strong></th>
            <th style="width: 15%;"><strong style="color: #000000">Precio unitario ($)</strong></th>
       	</tr>
    </thead>
 	
 	<tbody>
        @foreach ($detalle as $d) 
        <tr class="atributos">
            <td style="width: 15%;">{{$d->articulo->id_especifico}}</td>
            <td style="width: 15%;">{{$d->articulo->getCodigoArticuloReporte()}}</td>
            <td style="width: 30%;">{{$d->articulo['nombre_articulo']}}</td>
            <td style="width: 15%;">{{$d->articulo['unidad']['nombre_unidadmedida']}}</td>
            <td style="width: 10%;">{{$d->cantidad_solicitada}}</td>     
           <td style="width: 15%;">${{number_format($d->precio,2,'.','')}}</td>
        </tr>
    @endforeach
	</tbody>
 </table>

    <br><br><br>
    <hr size="2px" style="color: #5f2434" />

    <h3>Observaci&oacute;n: <strong>
    @if(empty($requisicion->observacion))
        <td> - - Ninguna - -</td>
    @else
        <td>{{$requisicion->observacion}}</td>
    @endif
    </strong></h3>

    <h3> Progreso: <strong>
    @if(($requisicion->estado == 'aprobada'))
    <h2 style="color: #005733">{{$requisicion->estado}}</h2>
    @else 
    <h2 style="color: #001a57">{{$requisicion->estado}}</h2>
    @endif
    </strong> </h3>
        
    
 
       