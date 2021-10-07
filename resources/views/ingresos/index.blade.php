@extends('layouts.template')
@section('css')
    <style>

        .op{
            width: 120px;
        }
    </style>
    @endsection

@section('content')
    <div class="encabezado">
        <h3>Ingresos</h3>
    </div>





<div class="table-responsive">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaIngreso">
    <thead>
    <tr class="info">
        <th colspan="8" class="centrado">Descripci&oacute;n</th>
        <th colspan="3" class="centrado">Saldo inicial</th>
        <th colspan="3" class="centrado">Entrada</th>
        <th colspan="3" class="centrado">Saldo final</th>
        <th colspan="2"></th>
    </tr>

        <tr class="success">
            <th>Nº</th>
            <th>Fecha</th>
            <th>Orden</th>
            <th>Factura</th>
            <th>Especifico</th>
            <th>Cod. Prod</th>
            <th>Producto</th>
	        <th>Unidad</th>
	        <th>Cant.</th>
			<th>Costo($)</th>
			<th>Monto($)</th>
	        <th>Cant.</th>
			<th>Costo($)</th>
			<th>Monto($)</th>
            <th>Cant.</th>
            <th>Costo($)</th>
            <th>Monto($)</th>
            <th>Opciones</th>
            <th></th>

	    </tr>
	</thead>
<tbody>
 
@foreach ($ingresos as $ingreso)

    <tr>

	    <td>{{$ingreso->id_ingreso}}</td>
        <td>{{$ingreso->transaccion->getFecha()}}</td>
        <td>{{$ingreso->orden}}</td>
        <td>{{$ingreso->num_factura}}</td>
        <td>{{$ingreso->transaccion->articulo->id_especifico}}</td>
        <td>{{$ingreso->transaccion->articulo->getCodigoArticuloReporte()}}</td>
        <td>{{$ingreso->transaccion->articulo->nombre_articulo}}</td>
		
        <td>{{$ingreso->transaccion->articulo->unidad->nombre_unidadmedida}}</td>
		<td>{{$ingreso->transaccion->exis_ant}}</td>
		<td>{{number_format($ingreso->pre_unit_ant,2,'.','')}}</td>
	    <td>{{number_format($ingreso->getMontoAnterior(),2,'.','')}}</td>
        <td>{{$ingreso->transaccion->cantidad}}</td>
        <td>{{number_format($ingreso->transaccion->pre_unit,2,'.','')}}</td>
        <td>{{number_format($ingreso->getMontoIngreso(),2,'.','')}}</td>
        <td>{{$ingreso->transaccion->exis_nueva}}</td>
        <td>{{number_format($ingreso->pre_unit_nuevo,2,'.','')}}</td>
        <td>{{number_format($ingreso->getMontoNuevo(),2,'.','')}}</td>
        <td class="">
            <a class="btn btn-default btn-sm" href="{{route('delete_ingreso',$ingreso->id_ingreso)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
            <a class="btn btn-default btn-sm" href="{{route('ingreso.edit',$ingreso->id_ingreso)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>

        </td>
        <td>
            <a class="btn btn-default btn-sm" title="Detalle" href="#"  onClick="mostrar_provider({{$ingreso->id_ingreso}})" data-target="p-modal"><span class="glyphicon glyphicon-th-large "></span></a>
        </td>
    </tr>
 @endforeach

</tbody>  
</table>
</div>
    @include('ingresos.details')
    @include('Msj.messages')

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  
    $('#TablaIngreso').DataTable(
      {         
          "lengthChange": false,
           "autoWidth": false,              
      });
  });

  var mostrar_provider= function(id){
      var route = "ingreso/detalle/"+id;
      $.get(route,function(data){
          $("#fecha").replaceWith( "<span id='fecha'>"+data.fecha+"</span>" );
          $("#articulo").replaceWith( "<span id='articulo'>"+data.articulo+"</span>" )
          $("#unidad").replaceWith( "<span id='unidad'>"+data.unidad+"</span>" );
          $("#proveedor").replaceWith( "<span id='prveedor'>"+data.proveedor+"</span>" );
          $("#telefono").replaceWith( "<span id='telefono'>"+data.telefono+"</span>" );
          $("#mail").replaceWith( "<span id='mail'>"+data.email+"</span>" );
          $("#vendedor").replaceWith( "<span id='vendedor'>"+data.vendedor+"</span>" );
          $("#especifico").replaceWith( "<span id='especifico'>"+data.especifico+"</span>" );
          $("#p-modal").modal();
      });
  }
</script>
@endsection
