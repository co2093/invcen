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
          <a 
            class="btn btn-default btn-sm"
            title="Agregar a requisicion"
            href="#ventana1"
            data-toggle="modal"
            onClick='agregarArticulo("{{$a->codigo_articulo}}","{{$a->nombre_articulo}}","{{$a->unidad->nombre_unidadmedida}}","{{$a->existencia}}","{{$a->getCodigoArticuloReporte()}}")'>           
            <span class="glyphicon glyphicon-plus">
            </span>
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
                <h3 class="modal-title">Agregar al plan de compras</h3>
            </div>
            <!-- contenido de la ventana1 -->
            <div  class="modal-body">
                <dl class="dl-horizontal">
                    <dt>Código:</dt>
                    <dd id="cod"></dd>
                    <dt>Nombre del producto: </dt>
                    <dd id="articulo"></dd>
                    <dt >Unidad de medida:</dt>
                    <dd id="unidad"></dd>
                    <dt>Existencia en bodega:</dt>
                    <dd id="existencia"></dd>

                </dl>
                {!! Form::open(array('route' => 'add.plancompras','class' => 'form-horizontal','method' => 'post','name' =>'addproduct')) !!}
                {{ csrf_field() }}
                <input  id="codigo" name="codigo" type="hidden"  class="form-control" />
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad a solicitar:</label>
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

var agregarArticulo= function(id,articulo,unidad,existencia,codp){
    $("#cantidad").val('');
    $("#codigo").val(id);
    $("#cod").html(codp);
    $("#articulo").html(articulo);
    $("#unidad").html(unidad);
    $("#existencia").html(existencia);
}

var validar = function () {
    var cantidad = parseInt($("#cantidad").val());
    if (cantidad < 1 || cantidad > 1000){
        alert("Cantidad debe ser un valor positivo menor a 1000");
}else{
        if(cantidad > 0 || cantidad <=1000){
            document.addproduct.submit();
        }else {
            alert("Cantidad debe ser un numero positivo");
        }
    }
}
</script>
@endsection