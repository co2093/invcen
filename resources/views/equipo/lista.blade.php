@extends('layouts.template')
@section('css')

<link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
<style type="text/css">

  .btn-xs{
    margin: .5px;
    width: 25px;
  }
  input[type=checkbox] {
      transform: scale(1.5);
    }


</style>
@endsection
@section('content')
<div class="encabezado">
  <h3>Equipos</h3>
  <div class="pull-left">
    <form method="POST" target="_blank" action="{{route('equipo.excel')}}">
      {{ csrf_field() }}
      <button type="submit" class="btn btn-warning btn-perspective" title="Exportar a excel"><i class="fa fa-file-excel-o"></i> Exportar A Excel</button>
    </form>    
  </div>
  <div class="pull-right">    
    <a onclick="modalInsertar();" class="btn btn-success" title="Insertar Equipo"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>
  </div>
</div>


<br><br>
<div class="panel panel-success">
    
    <div class="panel-heading" >
        <h3 class="panel-title">
            B&uacute;squeda de equipos
        </h3>
    </div>    
    <div id="collapse-filter" class="">
        <div class="panel-body">

            {{-- COLLAPSE CONTENT --}}
            <form role="form" id="search-form">
              <div class="row">                                
                <div class="form-group col-xs-12 col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon"><b>TIPO DE EQUIPO</b></div>            
                    <select class="form-control" id="ftipo" name="ftipo">
                      <option value="">Seleccione</option>
                      @foreach($tipos as $tipo)
                       <option value="{{$tipo->id_tipo_equipo}}">{{$tipo->nombre_tipo_equipo}}</option>
                      @endforeach
                    </select>   
                  </div>
                </div>                
                <div class="form-group col-xs-12 col-md-6">
                  <div class="input-group">
                    <div class="input-group-addon"><b>ESTADO</b></div>            
                    <select class="form-control" id="festado" name="festado">
                      <option value="">Seleccione</option>
                      @foreach($estados as $estado)
                       <option value="{{$estado->idestado}}">{{$estado->estado}}</option>
                      @endforeach
                    </select>   
                  </div>
                </div>
                <div class="form-group col-xs-12 col-md-6 col-lg-6">
                  <div class="input-group">
                      <div class="input-group-addon"><b>NÚMERO DE INVENTARIO</b></div>
                      <input type="text" id="num_inventario" name="num_inventario" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="form-group col-xs-12 col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon"><b>NÚMERO DE SERIE</b></div>
                        <input type="text" id="num_serie" name="num_serie" class="form-control" autocomplete="off">
                    </div>
                </div>                
              </div>
                                           
              <div class="modal-footer" >
                <div align="center">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}" class="form-control"/>
                <button type="submit" class="btn btn-success btn-perspective" id="btnConsultar"><i class="fa fa-search"></i> Buscar</button>
               </div>
              </div>                   
            </form>
            {{-- /.COLLAPSE CONTENT --}}
        </div><!-- /.panel-body -->
    </div><!-- /.collapse in -->
</div>

<div class="table-responsive">
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
<table class="table table-hover table-striped table-bordered table-condensed" id="dt_equipos" >
    <thead>
        <tr class="success">
          <th>TIPO</th>
          <th>NÚMERO INVENTARIO</th>           
	        <th>NÚMERO SERIE</th>
          <th>MARCA</th>
          <th>MODELO</th>
          <th>DESCRIPCIÓN</th>
          <th>ESTADO</th>          
          <th>RESPONSABLE</th>
          <th>UBICACION</th>
          <th>ACCIONES</th>
	    </tr>
	</thead>
<tbody>

</tbody>  
</table>
</div>

{{--INSERTAR EQUIPO--}}
  @include('equipo.form.insertarEquipo')
{{--INSERTAR EQUIPO--}}


@endsection

@section('script')
{!! Html::script('plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
<script src="{{asset('bootstrap/js/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
var table;
  $(document).ready(function(){
  
    $("#fecha_adquisicion").css("z-index", "9999");
    $(".datepicker2").datepicker({
        appendText: "(yy-mm-dd)",
        dateFormat: "yy-mm-dd"
    });

    table = $('#dt_equipos').DataTable({
        filter:false,
        processing: true,
        serverSide: true,
        lengthChange: false,
        ajax: {processing: true,
            url: "{{ route('equipo.get.lista') }}",
            data: function (d) {
               d.ftipo = $("#ftipo").val(),
               d.festado = $("#festado").val(),
               d.num_inventario = $("#num_inventario").val(),
               d.num_serie = $("#num_serie").val()
            }
            
        },
        columns: [           
            {data: 'tipo', name: 'tipo'},
            {data: 'numero_inventario', name: 'numero_inventario'},
            {data: 'numero_serie', name: 'numero_serie'},
            {data: 'marca', name: 'marca'},
            {data: 'modelo', name: 'modelo'},
            {data: 'descripcion', name: 'descripcion'},
            {data: 'status', name: 'id_estado'},
            {data: 'responsable', name: 'responsable'},
            {data: 'ubicacion', name: 'ubicacion'},
            {data: 'opciones', name: 'opciones',searchable:false,orderable:false}        
        ],
        language: {
            "sProcessing": '<div class=\"dlgwait\"></div>',
           // "url": "{{ asset('plugins/datatable/lang/es.json') }}"
            
            
        },
         columnDefs: [
            {                
              "visible": false             
            }
        ]    
    }); //end Datatable

    $('#search-form').on('submit', function(e) { 

        table.draw();
        e.preventDefault();
       //$("#colp").attr("class", "block-collapse collapsed");
       // $("#collapse-filter").attr("class", "collapse");
    });

    table.rows().remove();
   
  });

  

function modalInsertar(){
  $("#id_equipo").val(''); 
  $("#tipoEquipo").val('');
  $("#numInventario").val('');
  $("#especifico").val();
  $("#numSerie").val('');
  $("#modelo").val();
  $("#modelo").val('');
  $("#descripcion").val('');
  $("#observacion").val('');
  $("#estado").val('');
  $("#responsable").val('');
  $("#ubicacion").val('');
  $("#fecha_adquisicion").val();
  $("#procedencia").val('');
  $("#precio").val('');
  $("#dlgInsertarEquipo").modal('toggle');
}

  $('#insertarEquipo').submit(function(e){
        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);
    $.ajax({
      data: formData,
      url: formURL,
      type: 'post',
      mimeType:"multipart/form-data",
        contentType: false,
          cache: false,
          processData:false,
      beforeSend: function() {
        $('body').modalmanager('loading');
      },
          success:  function (response){
            $('body').modalmanager('loading');
            if(isJson(response)){
              var obj =  JSON.parse(response); 
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>información almacenada exitosamente!</p></strong>",function(){               
                table.ajax.reload();
                $("#cerrarMdl").trigger('click');
              });
              
            }else{
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>ADVERTENCIA:"+ response +"</p></strong>");
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
        $('body').modalmanager('loading');
        alertify.alert("Mensaje de Sistema","<strong><p class='text-danger text-justify'>ERROR: No se pudo registrar la información!</p></strong>");
              console.log("Error en peticion AJAX!");  
          }
    });
    e.preventDefault(); //Prevent Default action. 

  }); 

  function mdlEditarEquipo(idEquipo)
  {
    $.get("{{route('get.equipo.to.editar')}}?param="+idEquipo, 
        function(data) {  
            var obj = data;             
            console.log(obj);
            $("#id_equipo").val(obj.id_equipo); 
            $("#tipoEquipo").val(obj.id_tipo_equipo);
            $("#numInventario").val(obj.numero_inventario);
            $("#especifico").val(obj.especifico);
            $("#numSerie").val(obj.numero_serie);
            $("#marca").val(obj.marca);
            $("#modelo").val(obj.modelo);
            $("#descripcion").val(obj.descripcion);
            $("#observacion").val(obj.observacion);
            $("#estado").val(obj.idestado);
            $("#responsable").val(obj.responsable);
            $("#ubicacion").val(obj.ubicacion);  
            $("#fecha_adquisicion").val(obj.fecha_adquisicion);          
            $("#procedencia").val(obj.procedencia);
            $("#precio").val(obj.precio);

            $("#dlgInsertarEquipo").modal('toggle');
        });
    
  }

  function isJson(str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  }

  /*function mostrarPrecio()
  {
    var opcion = $("#procedencia").val();
    if(opcion=='préstamo'||opcion=='donación')
    {
      $("#div_precio").hide();
    }
    else{
      $("#div_precio").show();
    }
  }*/

  function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

function fcnEliminar(idEquipo){
  alertify.confirm('NECESITA INFORMACIÓN',"Esta seguro que desea eliminar éste registro?",
    function(){
      var tk = $("#token").val();
      $.ajax({
        data:  {_token:tk,param:idEquipo},
        url:   "{{route('equipo.eliminar')}}",
        type:  'post', 
        beforeSend: function () {
          //$('body').modalmanager('loading');
          //$("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response) { 
          if(response.status==200){
              alertify.alert("Mensaje de Sistema","<strong><p class='text-justify'>Eliminación exitosa!</p></strong>",function(){
                //var obj =  JSON.parse(response);
                table.ajax.reload();
              });
              
            }else{                     
              //console.log(response);
              alertify.alert("Mensaje de Sistema","<strong><p class='text-warning text-justify'>Se produjo un error!</p></strong>")
            }
        }
      });
    },
    function(){
      alertify.error('Acción cancelada!');        
  });
}
</script>
@endsection
