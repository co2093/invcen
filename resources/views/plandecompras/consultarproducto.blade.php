@extends('layouts.template')
@section('css')
    <style>
        .mov{
            margin-left: 15px;
        }

    </style>
    @endsection

@section('content')

<a href="javascript:window.history.back();" class="btn btn-primary mov" title="Ver requisicion">Ver plan de compras</a>
<div class="panel-body table-responsive">


<table class="table table-hover table-striped table-bordered table-condensed" id="TablaProd">
<thead>
    <tr>
        <th>Espec&iacute;fico</th>
        <th>C&oacute;d. prod.</th>
        <th>Producto</th>
        <th>Unidad de Medida</th>
        <th>Existencias en bodega</th>
        <th>Agregar</th>
    </tr>
 </thead>
<tbody>
 
@foreach ($articulos as $a) 

    <tr>
        <td>{{$a->id_especifico}}</td>
        <td>{{$a->getCodigoArticuloReporte()}}</td>
        <td>{{$a->nombre_articulo}}</td>        
        <td>{{$a->unidad->nombre_unidadmedida}}</td>
        <td>{{$a->existencia}}</td>       
        <td >
          <a class="btn btn-default btn-sm" href="{{route('plandecompras.solicitar', $a->codigo_articulo)}}">           
            <span class="glyphicon glyphicon-plus">
            </span>
          </a>
          
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

        $('#TablaProd').DataTable(
            {
                "lengthChange": false,
                "autoWidth": false
            });
    });
</script>
@endsection