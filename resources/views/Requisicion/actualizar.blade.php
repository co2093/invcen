@extends('layouts.template')

@section('css')
    <style>
        .derecha{
            float: right;
        }
    </style>
    @endsection

@section('content')
    <a href="{{route('requisicion-listar')}}" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</a>

    <h3>Unidad/Usuario : {{$requisicion->departamento['name']}}</h3>
<div class="panel-body table-responsive ">


<input type="hidden"  id="codArticulo">
<input type="hidden" name="varAnterior" id="varAnterior" value="-55">

    {!! Form::open(array('route' => ['requisicion.detalle.aprobar','id'=>$requisicion->id],'class' => 'form-horizontal','method' => 'put')) !!}
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-md-7">
            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Aprobar</button>

        </div>
    </div>

    <div class="form-group">

        {!!Form::label('OrdenRequisicion', 'Orden Requisicion*', array('class' =>'col-md-3 control-label' )) !!}
        <div class="col-md-6">
            {!!Form::text('ordenrequisicion', $requisicion->ordenrequisicion, array('placeholder' => '0686','class' => 'form-control')) !!}
            <div class="error">
                <ul>@foreach($errors->get('ordenrequisicion') as $msg)<li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>

    {!! Form::close() !!}


<table class="table table-hover table-striped table-bordered table-condensed" id="TablaDetalleRequesicion">
    <caption><strong>Solicitud: {{$requisicion->getNumero()}}</strong></caption>
    <thead>

    <tr>
        <th>Existencia</th>
        <th>C&oacute;d. prod.</th>
        <th>Producto</th>
        <th>Unidad de Medida</th>
        <th>Cant. solicitada</th>
        <th>Cant. aprobada</th>
        <th>Precio</th>
        <th>Sub total aprobado</th>
        <th>-</th>
    </tr>
 </thead>
<tbody>
 
@foreach ($detalle as $d) 

    <tr>
        <td>{{$d->articulo->existencia}}</td>
        <td>{{$d->articulo->getCodigoArticuloReporte()}}</td>
        <td>{{$d->articulo['nombre_articulo']}}</td>
        <td>{{$d->articulo['unidad']['nombre_unidadmedida']}}</td>
        <td>{{$d->cantidad_solicitada}}</td>     
        <td>
         {!!Form::model($detalle,['route'=>['requisicion.detalle.update',$d->id],'method'=>'patch','id'=>"frm$d->id"])!!}
            {{ csrf_field() }}
            <input 
                type="number" 
                min="0" 
                max="1000" 
                name="cantidad"                
                value="{{$d->cantidad_entregada}}" 
            >
            @if($d->cantidad_entregada>0)
            <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i></button>
            @else
            <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-refresh"></i></button>
            @endif            
                  
          {!!Form::close()!!}
        </td>
        <td>${{number_format($d->precio,2,'.','')}}</td>
        <td>${{number_format($d->getMonto(),2,'.','')}}</td>
        <td>
           @if($d->articulo['es_reactivo']=='S')
            <a onclick="mdlReactivosAgregados('{{$d->articulo_id}}','frm{{$d->id}}','{{$d->id}}');" title="asignar equipos" class="btn btn-default"><span class="glyphicon glyphicon-th-large"></span></a>
           @endif
        </td>
    </tr>
  
@endforeach
<tr>
    <td colspan="6">
        <div class="text-right">
        <strong>Total aprobado</strong>
        </div>
    </td>
    <td colspan="2">
        <strong>
    ${{number_format($requisicion->getMonto(),2,'.','')}}

    </strong>
    </td>
    <td></td>
</tr>
</tbody>  
</table>
</div>
    <div class="panel panel-info">
        <div class="panel-heading">
            Observaci&oacute;n
        </div>
        <div class="panel-body">
            <a href="{{route('requisicion-observacion',$requisicion->id)}}" class="btn btn-primary btn-sm derecha"><span class="glyphicon glyphicon-pencil"></span> Editar</a>

            {{$requisicion->observacion}}
        </div>
    </div>

{{-- modal para asignar los equipos a la requisicion --}}

<div class="modal fade" id="dlgAsignarReactivos" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success">
                <div class="btn-primary pull-right">
                    <a class="btn-primary" onclick="mdlReactivos();"><span class="glyphicon glyphicon-plus"></span>Agregar</a>
                </div>
                <h4 class="modal-title">
                    ASIGNAR REACTIVOS A LA SOLICITUD  
                </h4>

            </div>
                
            <!-- Modal Body -->
            <div class="modal-body">               
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="tablaReactivosAgregados">
                        <thead>
                            <tr>
                                <th>CANTIDAD EXISTENCIA</th>
                                <th>FECHA EXPIRA</th> 
                                <th>CANTIDAD ASIGNADA</th>                             
                                <th></th>
                            </tr>
                          
                        </thead> 
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>                          
            </div>
            <!-- End Modal Body -->
            <!-- Modal Footer -->
            <div class="modal-footer">                        
                <div class="panel panel-footer text-center">                   
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal">
                                Aceptar</button>
                </div>               
            </div>
        </div>
    </div>
</div>

<!-- Modal Equipos-->
<div class="modal fade" id="frmReactivo" aria-labelledby="frmReactivo" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
                    <!-- Modal Header -->
      <div class="modal-header bg-success">
        <button type="button" class="close" 
           data-dismiss="modal">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Cerrar</span>
        </button>
        <h4 class="modal-title" id="frmModalLabel">
           SELECCIONES UNO O MÁS ELEMENTOS
        </h4>
      </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-right">           
        <form class="navbar-form navbar-left" role="search">
        
        </form>
      </div><!-- /.navbar-collapse -->
      </br>                
      <!-- Modal Body -->
      <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-hover" id="dt-reactivos" width="100%">
              <thead class="the-box dark full">
                <tr>
                  <tr>
                    <th>CANTIDAD EXISTENCIA</th>
                    <th>FECHA EXPIRA</th>
                    <th></th>                    
                </tr>
              </thead>
              <tbody>
              
              </tbody>
            </table>
          </div>
      </div>
      <!-- End Modal Body -->
      <!-- Modal Footer -->
      <div class="modal-footer">
          <button type="button"  class="btn btn-primary" onclick="guardarReactivos();" data-dismiss="modal">Aceptar</button>                        
      </div>
    </div>
  </div>
</div>
  <!-- End Modal form -->      
@endsection

@section('script')
<script type="text/javascript"> 
var dataAddReactivos = [];

  $(document).ready(function(){
  
    
  });  
function mdlReactivosAgregados(idA,idFrm, idDetalle){ 
    dataAddReactivos.length=0;  
    var dtEquipos = $('#dt-reactivos').DataTable({
          processing: true,
          filter:true,
          serverSide: true,
          destroy: true,
          pageLength: 5,
          lengthChange: false,
          filter: false,
          ajax: {
            url: "{{route('get.existencia.reactivos')}}",
            data: function (d) 
            {
              d.articulo = idA;
              d.detalle = idDetalle;                                         
            }

          },
          columns:[                        
                  {data: 'restante', orderable:false, searchable:false},
                  {data: 'fecha_expira'},                                                           
                  {       searchable: false,
                          "mData": null,
                          "bSortable": false,
                          "mRender": function (data,type,full) 
                          { 
                            return '<input type=checkbox data-fecha_expira="'+data.fecha_expira+'"data-existencia="'+data.restante+'"data-articulo="'+idA+'" data-idfrm="'+idFrm+'" class="ckb-check">'; 
                           }
                  }
              ],
         language: {         
                    
      },                            
    });

    var anterior = $("#varAnterior").val();
    if(anterior!=idFrm)
    {
        $("#tablaReactivosAgregados tr").remove(); 

        $.get("{{route('get.reactivos.asignados')}}?param="+idDetalle+'&articulo='+idA, 
        function(data) {  
            var obj = data;             
            console.log(obj); 

            $.each( obj, function( key, value ) {              
              console.log(value);
              $('#tablaReactivosAgregados').append('<tr><td><input type="hidden" name="codfechas[]" value="'+value.fecha_expira+'" form="'+idFrm+'">'+value.quedan+'</td><td>'+value.fecha_expira+'</td><td><input type="number" name="codasignacion[]" value="'+value.cantidad+'" form="'+idFrm+'" min="1" required></td><td><a class="btn btn-danger btn-perspective btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>');
            });   
        });
    } 
    
    /*se asigna la variable del detalle actual*/   
    $("#varAnterior").val(idFrm);

    $("#codArticulo").replaceWith( '<input type="hidden" name="codArticulo" value="'+idA+'" form="'+idFrm+'" id="codArticulo">' );
      
    $('#dlgAsignarReactivos').modal('toggle');
    
}
function mdlReactivos(){
    $('#frmReactivo').modal('toggle');
}

$(document).on('click','.ckb-check',function(e) {
   if (this.checked) {
        dataAddReactivos.push([$(this).data("idfrm"),$(this).data("articulo"),$(this).data("existencia"),$(this).data("fecha_expira")]);
        console.info(dataAddReactivos);
      } else {
        
      }
    data=dataAddReactivos;
});

$("#tablaReactivosAgregados").on('click', '.btnEliminar', function () {
      $(this).closest('tr').remove();
  });

function guardarReactivos()
{
    for (var i =0; i< dataAddReactivos.length;i++) {
      
      $('#tablaReactivosAgregados').append('<tr><td><input type="hidden" name="codfechas[]" value="'+dataAddReactivos[i][3]+'" form="'+dataAddReactivos[i][0]+'">'+dataAddReactivos[i][2]+'</td><td>'+dataAddReactivos[i][3]+'</td><td><input type="number" name="codasignacion[]" value="" form="'+dataAddReactivos[i][0]+'" min="1" required></td><td><a class="btn btn-danger btn-perspective btnEliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>');
      
    }
}
</script>
@endsection