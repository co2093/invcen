@extends('layouts.template')

@section('css')
    <style>
        .derecha{
            float: right;
        }
    </style>
    @endsection

@section('content')
<a href="{{url('requisicion/listar')}}" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>
<p></p>
{!! Form::open(array('route' => ['requisicion.detalle.aprobar','id'=>$requisicion->id],'class' => 'form-horizontal','method' => 'put')) !!}
{{ csrf_field() }}
{!!Form::hidden('ordenrequisicion', $requisicion->ordenrequisicion, array('placeholder' => '0686','class' => 'form-control')) !!}

<div class="form-group">
    <div class="col-md-7">
        <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check"></span> Aprobar</button>
        <a class="btn btn-primary btn-sm" title="Volver a editar" href="{{route('editar-confirm',$requisicion->id)}}"><span class="glyphicon glyphicon-pencil"></span> Volver a editar</a>
        <a class="btn btn-danger btn-sm" title="Denegar" href="{{route('requisicion.denegar',$requisicion->id)}}"><span class="glyphicon glyphicon-trash"></span> Denegar</a>

    </div>
</div>

{!! Form::close() !!}

 <h3>Unidad/Usuario : {{$requisicion->departamento['name']}}</h3>
 <h4>Orden requisici&oacute;n nº {{$requisicion->ordenrequisicion}}</h4>
 <div class="panel-body table-responsive ">
 
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaDetalleRequesicion">
    <caption><strong>Solicitud: {{$requisicion->getNumero()}}</strong></caption>
    <thead>
    <tr>
        <th>Existencia</th>
        <th>C&oacute;d. prod</th>
        <th>Producto</th>
        <th>Unidad de Medida</th>
        <th>Cant Solicitada</th> 
        <th>Cant Aprobada</th>
        <th>Precio</th>
        <th>Sub total</th>
    </tr>
 </thead>
<tbody>
 
@foreach ($detalle as $d) 

    <tr>
        <td>{{$d->articulo->existencia}}</td>
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
                Monto total
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
            <a href="{{route('requisicion-observacion',$requisicion->id)}}" class="btn btn-primary btn-sm derecha"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
            {{$requisicion->observacion}}
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