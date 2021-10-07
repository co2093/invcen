@extends('layouts.template')

@section('content')
<div class="encabezado">
<h3>Tipos de equipos</h3>
</div>
<a href="{{ route('equipo.nuevo.tipo')}}" class="btn btn-success" title="Nuevo producto"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

<div class="table-responsive">
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
<table class="table table-hover table-striped table-bordered table-condensed" id="tb_tipos_equipos" >
    <thead>
        <tr class="success">
          <th>Número</th>
          <th>Nombre de tipo</th>           
	        <th>Opciones</th>
	    </tr>
	</thead>
<tbody>

@for($i=0; $i< count($tiposEquipos); $i++)
    <tr>
      <td>{{$i+1}}</td>
      <td>{{$tiposEquipos[$i]->nombre_tipo_equipo}}</td>
	    <td class="col-md-3">
	        <a class="btn btn-default btn-sm" onclick="EliminarTipo('{{$tiposEquipos[$i]->id_tipo_equipo}}');" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
	     
	        <a class="btn btn-default btn-sm" href="{{route('tipo.equipo.editar',\Crypt::encrypt($tiposEquipos[$i]->id_tipo_equipo))}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>          
	    </td>
	    
    </tr>
 @endfor

</tbody>  
</table>
</div>

@endsection

@section('script')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}

<script type="text/javascript">
  $(document).ready(function(){
  
    $('#tb_tipos_equipos').DataTable(
      {         
          "lengthChange": false,
           "autoWidth": false  
      });
  });

  function EliminarTipo(idTipo)
  {
    alertify.confirm('NECESITA CONFIRMACIÓN',"se eliminara el tipo de equipo, desea contunuar?",
      function(){ 
        var tk = $("#token").val();
        $.ajax({
          data:{_token:tk,idtipo:idTipo},
          url:   "{{route('tipo.equipo.eliminar')}}",
          type:  'post',
         
          beforeSend: function() {
              $('body').modalmanager('loading');
          },
          success:  function (response){
                  $('body').modalmanager('loading');
                  //console.log(response);
                  if(response.status==200){
                    alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>El tipo de equipo se eliminó de forma exitosa!</p></strong>",function(){
                        window.location.href = "{{route('equipo.lista.tipos')}}";
                    });
                    
                  }else{                     
                    //console.log(response);
                    alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response.message +"</p></strong>")
                  }
                },
          error: function(jqXHR, textStatus, errorThrown) {
              $('body').modalmanager('loading');
              alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo eliminar el tipo de equipo!</p></strong>");
                    console.log("Error en peticion AJAX!");  
                }
        });
      },
      function(){
        alertify.error('Acción cancelada');    
      }
    ).set('labels', {ok:'Aceptar', cancel:'Cancelar'});
  } 
</script>
@endsection


