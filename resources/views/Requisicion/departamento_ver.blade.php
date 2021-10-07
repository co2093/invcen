@extends('layouts.template')
@section('css')
    <style>
    .margen{
    margin-bottom: 7px;
    }
    </style>
    @endsection

@section('content')
    <div class="encabezado">
        <h3>Unidad/Usuario : {{$requisicion->departamento['name']}}</h3>
    </div>


<a href="javascript:window.history.back();" class="btn btn-default margen"><span class="glyphicon glyphicon-arrow-left"></span>Regresar</a>
    <p><strong>Orden requisici&oacute;n nº:</strong> {{$requisicion->ordenrequisicion}}</p>

<div class="table-responsive">
 
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaDetalleRequesicion">
<thead>
<tr class="info">
    <td colspan="8" class="text-center">
        <strong>N&uacute;mero de solicitud: {{$requisicion->getNumero()}}</strong>
    </td>
</tr>
    <tr class="success">
        <th>Espec&iacute;fico</th>
        <th>C&oacute;d. prod.</th>
        <th>Producto</th>
        <th>Unidad de Medida</th>
        <th>Cantidad Solicitada</th>
        <th>Cantidad Aprobada</th>
        <th>Precio</th>
        <th>Sub total aprob.</th>
    </tr>
 </thead>
<tbody>

@foreach ($detalle as $d) 

    <tr class="">
        <td>{{$d->articulo->id_especifico}}</td>
        <td>{{$d->articulo->getCodigoArticuloReporte()}}</td>
        <td>{{$d->articulo['nombre_articulo']}}</td>
        <td>{{$d->articulo['unidad']['nombre_unidadmedida']}}</td>
        <td>{{$d->cantidad_solicitada}}</td>     
        <td>{{$d->cantidad_entregada}}</td>
        <td>${{number_format($d->precio,2,'.','')}}</td>
        <td>${{number_format($d->getMonto(),2,'.','')}}</td>
    </tr>
  
@endforeach
<tr>
    <td colspan="6">
        <div class="text-right">
            <strong>
                @if($requisicion->estado == 'denegado')
                    Monto total no aprobado
                    @else
                Monto total aprobado
                    @endif
            </strong>

        </div>
    </td>
    <td colspan="2">
        <strong>
    ${{number_format($requisicion->getMonto(),2,'.','')}}
    </strong>

    </td>
</tr>
</tbody>
</table>
</div>
<br/>

    <div class="panel panel-info">
        <div class="panel-heading">
            <strong>Observaci&oacute;n</strong>
        </div>
        <div class="panel-body">
            {{$requisicion->observacion}}
        </div>

    </div>

<div class="panel panel-info">
    <div class="panel-heading">
        <strong>Progreso</strong>
    </div>
    <div class="panel-body">
        <div class="btn-group">
            @if($requisicion->estado == 'enviada' || $requisicion->estado == 'actualizada' || $requisicion->estado == 'aprobada' || $requisicion->estado =='denegado' || $requisicion->estado == 'editar')
            <button class="btn"><span class="glyphicon glyphicon-ok"></span>Enviada</button>
                @else
                <button class="btn">Enviada</button>
            @endif
                @if($requisicion->estado == 'editar')
                    <button class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span> En edici&oacute;n</button>
                @endif
            @if($requisicion->estado == 'actualizada' || $requisicion->estado == 'aprobada' || $requisicion->estado =='denegado')
                <button class="btn"><span class="glyphicon glyphicon-ok"></span> Revisada</button>
                @else
                    <button class="btn">Revisada</button>
            @endif
                @if($requisicion->estado == 'aprobada')
            <button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Aprobada</button>
                @else
                    <button class="btn">Aprobada</button>
                @endif
                @if($requisicion->estado == 'denegado')
            <button class="btn btn-danger"><span class="glyphicon glyphicon-ok"></span> Denegada</button>
                    @else
                    <button class="btn">Denegada</button>
            @endif
        </div>

    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  
    $("#TablaDetalleRequesicion").DataTable(
      {
        "lengthChange": false,
        "searching": false,
        "info": false,
      });
  });
</script>
@endsection