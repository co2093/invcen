@extends('layouts.template')

@section('content')

<div class="panel-body table-responsive">

<table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisiciones">
<thead>
    <tr>    
        <th>Fecha de Solicitud</th>  
        <th>Estado</th>         
        <th></th>
    </tr>
 </thead>
<tbody>
 
@foreach ($requisicion as $r) 

    <tr>
        <td>{{$r->fecha_solicitud}}</td>  
        <td>{{$r->estado}}</td>     
        <td>
          <a class="btn btn-default btn-sm" title="editar" href="{{route('requisicion.detalle.edit',$r->id)}}"><span class="glyphicon glyphicon-th-large "></span></a>
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
          "searching": false,
          "ordering": true,
          "info": false,
          "autoWidth": true
      });
  });  


</script>
@endsection