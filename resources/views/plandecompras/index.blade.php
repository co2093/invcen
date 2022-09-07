@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Plan de compras de {{Auth::user()->name}}</strong>
                <br><br>
                <strong>Monto total solicitado: ${{number_format(($total->final),2,'.','')}}</strong>
			</h4>
		</div>
	<div class="panel-body">

    <div>       
        <div>
            <a href="{{route('plandecompras.productos')}}" class="btn btn-info" title="Agregar producto">Consultar productos en bodega</a>
            <a href="{{route('plandecompras.agregarNuevo')}}" class="btn btn-primary" title="SolicitarNuevo">Solicitar producto nuevo</a>
            <a href="{{route('plandecompras.excel.descargar')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
            <a href="{{route('plandecompras.pdf.descargar')}}" class="btn btn-danger" title="DescargarPDF">Descargar en PDF</a>
        </div>
    </div>

    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Cantidad</th>
                <th>Nombre del producto</th>
                <th>Categoría</th>
                <th>Especificaciones</th>
                <th>Unidad de medida</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                
                <th>Proveedor</th>
                <th>Teléfono</th>
                <th>Cotización</th>
                <th colspan="2">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @if($planDelUsuario)
                @foreach ($planDelUsuario as $a)

                    <tr>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->categoria}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>{{$a->unidad}}</td>
                        <td>${{ number_format(($a->precio_unitario),2,'.','') }}</td>
                        <td>${{ number_format(($a->total),2,'.','') }}</td>
                       
                        <td>
                        @if($a->nuevoproveedor)
                            @foreach ($proveedores as $p)
                                @if ($p->telefono == $a->nuevoproveedor)
                                    {{$p->nombre}}
                                @endif
                            @endforeach                           
                        @else
                            {{$a->proveedor}}
                        @endif
                        </td>
                        <td>
                        @if($a->nuevoproveedor)
                            {{$a->nuevoproveedor}}
                        @else
                            @foreach ($proveedores as $p)
                                @if($a->proveedor == $p->nombre)
                                    {{$p->telefono}}
                                @endif
                            @endforeach
                        @endif

                        </td>
                        <td>
                            @if($a->cotizacion)
                            <a class="btn btn-secondary btn-sm"  title="Descargar" href="{{route('pladecompras.descargar', $a->cotizacion) }}"><span class="fa fa-download fa-2x"></span></a>
                           @else
                                No hay cotización
                           @endif
                           <!-- <a class="btn btn-danger btn-xs"  title="Eliminar" href="{{route('plandecompras.eliminar', $a->cotizacion) }}"><span class="fa fa-trash fa-2x"></span></a>
                           -->
                                                        
                        </td>
                        <td>
                        	<a href="{{route('plandecompras.edit', $a->id)}}" class="btn btn-default btn-sm" title="Editar">
                            <span class="glyphicon glyphicon-pencil">
                        </td>
                        <td>
                        	<a onclick="return confirm('¿Eliminar producto del plan de compras?')" href="{{route('plandecompras.deleteProduct', $a->id)}}" class="btn btn-danger btn-sm" title="Eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </td>
                    </tr>

                @endforeach
            @endif
            </tbody>
        </table>


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


    </script>
@endsection