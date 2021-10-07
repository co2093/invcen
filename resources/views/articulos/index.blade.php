@extends('layouts.template')

@section('content')
<div class="encabezado">
<h3>Productos</h3>
</div>
<a href="{{ route('articulo.create')}}" class="btn btn-success" title="Nuevo producto"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaArticulo" >
    <thead>
        <tr class="success">
            <th>Espec&iacute;fico</th>
            <th>C&oacute;d. prod.</th>
            <th>Producto</th>
	        <th>Unidad de medida</th>
	        <th>Opciones</th>
	    </tr>
	</thead>
<tbody>
 
@foreach ($articulos as $articulo)
    <tr>
        <td>{{$articulo->id_especifico}}</td>
        <td>{{$articulo->getCodigoArticuloReporte()}}</td>
        <td>{{$articulo->nombre_articulo}}</td>
	    <td>{{$articulo->unidad->nombre_unidadmedida}}</td>

	    <td class="col-md-3">
	        <a class="btn btn-default btn-sm" href="{{route('delete_articulo',$articulo->codigo_articulo)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
	        <a class="btn btn-default btn-sm" href="{{route('articulo.show',$articulo->codigo_articulo)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>
	        <a class="btn btn-default btn-sm" href="{{route('articulo.edit',$articulo->codigo_articulo)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
          <a class="btn btn-default btn-sm" href="{{route('addExistencia',$articulo->codigo_articulo)}}" title="Agregar existencia"><span class="glyphicon glyphicon-book"></span></a>

          
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
  
    $('#TablaArticulo').DataTable(
      {         
          "lengthChange": false,
           "autoWidth": false  
      });
  }); 
</script>
@endsection


