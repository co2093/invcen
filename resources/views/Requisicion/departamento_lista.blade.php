@extends('layouts.template')

@section('content')

<div class="panel-body table-responsive ">

    <div class="encabezado">
        <h3>Solicitudes</h3>
    </div>

<table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisiciones">
<thead>
    <tr class="success">
        <th>Fecha de Solicitud</th>
        <th>Nº Solicitud</th>
        <th>Estado</th>
        <th>Fecha de Aprobaci&oacute;n</th>
        <th></th>
    </tr>
 </thead>
<tbody>
 
@foreach ($requisicion as $r) 

    <tr>
        <td>{{$r->getFechaSolicitud()}}</td>
        <td>{{ $r->getNumero() }}</td>
        <td>
            @if($r->estado == 'actualizada')
                Revisada
            @elseif($r->estado == 'editar')
                <strong>En edici&oacute;n</strong>
            @else
            {{$r->estado}}</td>
            @endif
        <td>
          @if($r->estado=='aprobada')
            {{$r->getFechaEntrega()}}
          @endif
        </td>            
        <td>
          <a class="btn btn-default btn-sm" title="Detalle" href="{{route('requisicion.detalle.edit',$r->id)}}"><span class="glyphicon glyphicon-th-large "></span></a>
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
          "ordering": true,
          "info": false,
          "autoWidth": true
      });
  });  


</script>
@endsection