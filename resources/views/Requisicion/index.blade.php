@extends('layouts.template')

@section('content')
<div class="encabezado">
    <h3>Solicitudes</h3>
</div>
<div class="panel-body table-responsive ">

<table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisiciones">
<thead>
    <tr class="success">
        <th>N&uacute;mero</th>
        <th>Unidad/Usuario</th>  
        <th>Fecha de Solicitud</th>  
        <th>Estado</th>         
        <th>Opciones</th>
        <th>Reportes</th>
    </tr>
 </thead>
<tbody>
 
@foreach ($requisicion as $r) 

    <tr>  
        <td>{{$r->getNumero()}}</td>
        <td>{{$r->departamento['name']}}</td>
        <td>{{$r->getFechaSolicitud()}}</td>
        <td>
            @if($r->estado == 'actualizada')
                revisada
            @elseif($r->estado == 'editar')
                <strong>Editar</strong>
            @else
                {{$r->estado}}
            @endif
        </td>
        <td>                
         <a class="btn btn-default btn-sm" title="detalles" href="{{route('requisicion.detalle.show',$r->id)}}"><span class="glyphicon glyphicon-th-large "></span></a>
         @if($r->estado == 'aprobada')
         <a class="btn btn-default btn-sm" target="_blank" title="imprimir" href="{{url('requisicion/imprimir',$r->id)}}"><span class="glyphicon glyphicon-print "></span></a>
         {{--<a class="btn btn-default btn-sm" title="Desechar" href="{{route('requisicion-desechar',$r->id)}}"><span class="glyphicon glyphicon-remove "></span></a>--}}
         @else
            @if($r->estado != 'denegado')
            <a class="btn btn-default btn-sm" title="editar" href="{{route('requisicion.detalle.edit',$r->id)}}"><span class="glyphicon glyphicon-pencil "></span></a>
            @endif
          @endif
        </td>
        <td>
        <a class="btn btn-success btn-sm" target="_blank" title="archivo de excel" href=""><span class="fa fa-file-excel-o fa-2x"></span></a>
        <a class="btn btn-danger btn-sm" target="_blank" title="archivo PDF" href="{{route('requisicion.detalle.pdf',$r->id)}}"><span class=" fa fa-file-pdf-o fa-2x"></span></a>
        </td>
    </tr>
  
@endforeach
</tbody>  
</table>


</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  
    $("#TablaRequisiciones").DataTable(
      {
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": true
      });
  });  


</script>
@endsection