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
        <td class="ancho-l pad">
            <div class="text-center">
                <img src="dist/img/minerva.jpg" alt="Logo ues" style="width: 8em; height:10em;">
            </div>
        </td>
        <td class="ancho-c">
            <div class="text-center distancia">
                <strong>
                    Centro de Investigaciones y Desarrollo en Salud<br>
                    Universidad de El Salvador<br>
                    Plan de compras<br>
                </strong>
            </div>
        </td>
        <td class="ancho-r">
            <div class="text-center">
                <img src="dist/img/logocensalud.png" alt="logo CENSALUD" style="width: 300px;">              
            </div>
        </td>
    </tr>
</table>

<table class="table">
    <thead>
        <tr class="atributos">
            <th style="width: 10%;"><strong>Cantidad</strong></th>
            <th style="width: 15%;"><strong>Nombre del producto</strong></th>
            <th style="width: 15%;"><strong>Categoría</strong></th>
            <th style="width: 40%;"><strong>Especificaciones</strong></th>
            <th style="width: 10%;"><strong>Proveedor</strong></th>
            <th style="width: 5%;"><strong>Precio unitario ($)</strong></th>
            <th style="width: 5%;"><strong>Costo total ($)</strong></th>
       	</tr>
    </thead>
 	
 	<tbody>
        @foreach ($solicitudes as $s)
            <tr>
            	<td style="width: 10%;"><strong>{{$s->cantidad}}</strong></td>
                <td style="width: 15%;"><strong>{{$s->nombre_producto}}</strong></td>
                <td style="width: 15%;"><strong>{{$s->categoria}}</strong></td>
                <td style="width: 40%;"><strong>{{$s->especificaciones}}</strong></td>
                <td style="width: 10%;"><strong>{{$s->proveedor}}</strong></td>
                <td style="width: 5%;"><strong>{{round($s->precio_unitario,2)}}</strong></td>
                <td style="width: 5%;"><strong>{{round($s->precio_unitario,2)*$s->cantidad}}</strong></td>
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
            <div class="firma"><strong>ADMINISTRADOR FINANCIERO</strong></div>
    	</div>
 	</td>
    </tr>
</table>