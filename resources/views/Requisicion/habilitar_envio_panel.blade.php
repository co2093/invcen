@extends('layouts.template')

@section('content')
<div class="encabezado">
    <h3>Gestionar Envios</h3>
</div>
<a href="{{route('gestionar-envios',-7)}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Habilitar Todos</a>
<a href="{{route('gestionar-envios',-9)}}" class="btn btn-success"><span class="glyphicon glyphicon-warning-sign"></span> Deshabilitar Todos</a>
<div class="panel-body table-responsive ">
<table class="table table-hover table-striped table-bordered table-condensed" id="TablaDeptos">
<thead>
    <tr class="success">
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Encargado</th>
        <th>Estado</th>     
      <th></th>
    </tr>
 </thead>
<tbody>
 
@foreach ($departamentos as $d)
    <tr>  
        <td>{{$d->name}}</td>
        <td>{{$d->descripcion}}</td> 
        <td>{{$d->encargado}}</td> 
        @if($d->enviar=='true')
          <td>Habilitado</td>   
          <td class="col-md-5">          
              <a class="btn btn-success btn-sm" href="{{route('gestionar-envios',$d->id)}}"><span class="glyphicon glyphicon-minus-sign"> Deshabilitar</span></a>
        </td>
        @else         
            <td>Deshabilitado</td>   
            <td class="col-md-5">          
                <a class="btn btn-danger btn-sm" href="{{route('gestionar-envios',$d->id)}}"><span class="glyphicon glyphicon-plus-sign"> Habilitar</span></a>
            </td>
        @endif  
        </tr>
@endforeach
</tbody>  
</table>
</div>
     
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  
    $('#TablaDeptos').DataTable(
      {         
          "lengthChange": false,   
      });
  });  
</script>
@endsection


