
@extends('layouts.template')

@section('content')
<div class="encabezado">
<h3 style="display: inline-block;">Existencias</h3>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaExistencia">
    <thead>
     <tr class="success">
		    <th>Espec&iacute;fico</th>
            <th>C&oacute;d. Prod.</th>
            <th>Producto</th>
            <th>Categor&iacute;a</th>
	        <th>Unidad de medida</th>
	        <th>Existencia</th>
	        <th>Precio unitario</th>
	      
		    <th>Monto</th>
		      <th>Opciones</th>
	           
	 </tr>
	</thead>
	<tbody>
	 @foreach ($articulos as $a)
	 <tr>
		 <td>{{$a->id_especifico}}</td>
        <td>{{$a->getCodigoArticuloReporte()}}</td>
        <td>{{$a->nombre_articulo}}</td>
        <td>A</td>
	    <td>{{$a->unidad->nombre_unidadmedida}}</td>
	   @if ($a->existencia == 0)
	    <td style="color: red;">{{$a->existencia}}</td>
	   @else
	    <td >{{$a->existencia}}</td>
	   @endif	    
	    <td>${{number_format($a->precio_unitario,2,'.','')}}</td>
		 <td>${{number_format($a->monto(),2,'.','')}}</td>

		 	    <td>

	        <a class="btn btn-default btn-sm" href="#" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>


          
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
  
    $('#TablaExistencia').DataTable(
      {         
          "lengthChange": false,
           "autoWidth": false, 
      });
  }); 
</script>
@endsection
