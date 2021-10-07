@extends('layouts.template')

@section('content')
<div class="encabezado">
    <h3>Especif&iacute;cos</h3>
</div>

<a href="{{ route('especifico.create')}}" class="btn btn-success" title="Nuevo especifico"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaEspecifico">
<thead>
    <tr class="success">
        <th>N&uacute;mero</th>
        <th>T&iacute;tulo</th>
        <th>Descripci&oacute;n</th>
	    <th>Opciones</th>
    </tr>
</thead>
<tbody>
 
@foreach ($especificos as $especifico)
    <tr>  
        <td>{{$especifico->id}}</td>
        <td>{{$especifico->titulo_especifico}}</td>
        <td>{{$especifico->descripcion_epecifico}}</td>
	    <td class="col-md-3">
	        <a class="btn btn-default btn-sm" href="{{route('yes',$especifico->id)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
	        <a class="btn btn-default btn-sm" href="{{route('especifico.show',$especifico->id)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>
	        <a class="btn btn-default btn-sm" href="{{route('especifico.edit',$especifico->id)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
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
  
    $('#TablaEspecifico').DataTable(
      {         
          "lengthChange": false,
           "autoWidth": false  
      });
  }); 
</script>
@endsection


