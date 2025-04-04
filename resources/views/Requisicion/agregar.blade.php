@extends('layouts.template')
@section('css')
    <style>
        .mov{
            margin-left: 15px;
        }

    </style>
    @endsection

@section('content')

<a href="javascript:window.history.back();" class="btn btn-primary mov" title="Ver requisicion">Ver solicitud</a>
<div class="panel-body table-responsive">


<table class="table table-hover table-striped table-bordered table-condensed" id="TablaProd">
<thead>
    <tr>
        <th>Existencia</th>
        <th>C&oacute;d. prod.</th>
        <th>Producto</th>
        <th>Unidad de Medida</th>
        <th>Precio</th>
        <th></th>
    </tr>
 </thead>
<tbody>
 
@foreach ($articulos as $a) 

    <tr>
        <td>{{$a->existencia}}</td>
        <td>{{$a->codigo_articulo}}</td>
        <td>{{$a->nombre_articulo}}</td>        
        <td>{{$a->unidad->nombre_unidadmedida}}</td>
        <td>{{number_format($a->precio_unitario,2,'.','')}}</td>

    @php
        $nombre = preg_replace('/\r|\n/', '',$a->nombre_articulo);
        $nombre = addslashes($nombre);
    @endphp    
       

      <td >
        <a 
            class="btn btn-default btn-sm"
            title="Agregar a requisicion"
            href="#ventana1"
            data-toggle="modal"
            onclick='agregarArticulo({{ json_encode([
                "id" => $a->codigo_articulo,
                "nombre" => $a->nombre_articulo,
                "unidad" => $a->unidad->nombre_unidadmedida,
                "precio" => number_format($a->precio_unitario,2,'.',''),
                "codigo" => $a->codigo_articulo,
                "existencia" => $a->existencia
            ]) }})'
        >           
            <span class="glyphicon glyphicon-plus"></span>
        </a>

          
      </td>   
    </tr>
  
@endforeach
</tbody>  
</table>
</div>

<div class="modal" id="ventana1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Encabezado de la ventana1 -->
            <div class="modal-header">
                <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Agregar a la solicitud</h3>
            </div>
            <!-- contenido de la ventana1 -->
            <div  class="modal-body">
                <dl class="dl-horizontal">
                    <dt>Codigo:</dt>
                    <dd id="cod"></dd>
                    <dt>Producto: </dt>
                    <dd id="articulo"></dd>
                    <dt >Unidad de medida:</dt>
                    <dd id="unidad"></dd>
                    <dt>Precio unitario:</dt>
                    <dd id="precio"></dd>
                    <dt>Existencia:</dt>
                    <dd id="existencia"></dd>

                </dl>
                {!! Form::open(array('route' => 'add','class' => 'form-horizontal','method' => 'post','name' =>'addproducto')) !!}
                {{ csrf_field() }}
                <input  id="codigo" name="codigo" type="hidden"  class="form-control" />
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad a solicitar</label>
                        <div class="col-md-7">
                            <input  type="number" id="cantidad" name="cantidad"  min="1" max="1000" step="1" required  class="form-control" />
                        </div>
                    </div>
                    <div class="mov">
                    <div class="form-group">
                        <div class="col-md-offset-7">
                        <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="boton" class="btn btn-primary" onclick="validar()" selected>Agregar</button>
                        </div>
                    </div>
                    </div>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
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

    var agregarArticulo = function(articulo) {
        $("#cantidad").val('');
        $("#cod").html(articulo.codigo);
        $("#codigo").val(articulo.id);
        $("#articulo").html(articulo.nombre);
        $("#unidad").html(articulo.unidad);
        $("#precio").html(articulo.precio);
        $("#existencia").html(articulo.existencia);
    };


var validar = function () {
    var cantidad = parseInt($("#cantidad").val());
    if (cantidad < 1 || cantidad > 1000){
        alert("Cantidad debe ser un valor positivo menor a 1000");
}else{
        if(cantidad > 0 || cantidad <=1000){
            document.addproducto.submit();
        }else {
            alert("Cantidad debe ser un numero positivo");
        }
    }
}
</script>
@endsection