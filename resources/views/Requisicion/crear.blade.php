@extends('layouts.template')

@section('content')

    <div>
        <h4>Unidad/Usuario : <strong>{{Auth::User()->departamento['name']}}</strong></h4>
       
        <div>
            <a href="{{route('requisicion.detalle.index')}}" class="btn btn-success" title="Agregar producto">Agregar
                producto <i class="glyphicon glyphicon-plus"></i></a>
            <a href="{{route('requisicion-confirmar')}}" class="btn btn-success" title="Enviar">Enviar Solicitud <i
                        class="glyphicon glyphicon-new-window"></i></a>
            {{--@if ($requisicion)
            <a href="{{route('requisicion-observacion',$requisicion->id)}}" class="btn btn-success">Observaciones</a>
            @endif--}}
            <a href="{{route('requisicion-vaciar')}}" class="btn btn-default" title="Desechar">Vaciar</a>
        </div>
    </div>

    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Existencia</th>
                <th>C&oacute;d. prod.</th>
                <th>producto</th>
                <th>Unidad de Medida</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>SubTotal</th>
                <th colspan="2">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @if($articulos)
                @foreach ($articulos as $a)

                    <tr>
                        <td>{{$a->existencia}}</td>
                        <td>{{$a->getCodigoArticuloReporte()}}</td>
                        <td>{{$a->nombre_articulo}}</td>
                        <td>{{$a->unidad['nombre_unidadmedida']}}</td>
                        <td>{{$a->cantidad}}</td>
                        <td>${{number_format($a->precio_unitario,2,'.','')}}</td>
                        <td>${{number_format($a->precio_unitario*$a->cantidad,2,'.','')}}</td>
                        <td>
                            <a
                                    class="btn btn-default btn-sm"
                                    title="Editar cantidad"
                                    href="#ventana1"
                                    data-toggle="modal"
                                    onClick='agregarArticulo("{{$a->codigo_articulo}}","{{$a->nombre_articulo}}","{{$a->unidad->nombre_unidadmedida}}","{{number_format($a->precio_unitario,2,'.','')}}","{{$a->getCodigoArticuloReporte()}}")'
                            >
            <span class="glyphicon glyphicon-pencil">
            </span>
                            </a>
                        </td>
                        <td>
                            <a href="{{route('requisicion-delete',$a->codigo_articulo)}}" class="btn btn-danger btn-sm"
                               title="Eliminar">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>

                @endforeach
            @endif
            </tbody>
        </table>

        <h3>
		<span class="label label-default col-md-offset-5">
			Total :  $ {{number_format($total,2)}}
		</span>
        </h3>
    </div>


    {{-- Aca agregamos la ventana para actualizar la cantidad del articulo--}}

    <div class="modal" id="ventana1">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Encabezado de la ventana1 -->
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Agregar cantidad a solicitar</h3>
                </div>
                <!-- contenido de la ventana1 -->
                <div class="modal-body">
                    <dl class="dl-horizontal">
                        <dt>Codigo:</dt>
                        <dd id="cod"></dd>
                        <dt>Producto:</dt>
                        <dd id="articulo"></dd>
                        <dt>Unidad de medida:</dt>
                        <dd id="unidad"></dd>
                        <dt>Precio unitario:</dt>
                        <dd id="precio"></dd>

                    </dl>
                    {!! Form::open(array('route' => 'add','class' => 'form-horizontal','method' => 'post','name' =>'addproducto')) !!}
                    {{ csrf_field() }}

                    <input id="codigo" name="codigo" type="hidden" class="form-control">
                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad a solicitar</label>
                        <div class="col-md-7">
                            <input type="number" id="cantidad" name="cantidad" min="1" max="1000" step="1" required
                                   class="form-control">
                        </div>
                    </div>
                    <div class="mov">
                        <div class="form-group">
                            <div class="col-md-offset-7">
                                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="boton" class="btn btn-primary" onclick="validar()">Agregar
                                </button>
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
        $(document).ready(function () {

            $("#TablaRequisicion").DataTable(
                {
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


        //Agregamos el codigo para actualizar el articulo

        var agregarArticulo = function (id, articulo, unidad, precio, codp) {
            $("#cantidad").val('');
            $("#cod").html(codp);
            $("#codigo").val(id);
            $("#articulo").html(articulo);
            $("#unidad").html(unidad);
            $("#precio").html(precio);
        }

        var validar = function () {
            var cantidad = parseInt($("#cantidad").val());
            if (cantidad < 1 || cantidad > 1000) {
                alert("Cantidad debe ser un valor positivo no mayor a 1000");
            } else {
                if (cantidad > 0 || cantidad <= 1000) {
                    document.addproducto.submit();
                } else {
                    alert("Cantidad debe ser un numero");
                }
            }
        }
    </script>
@endsection