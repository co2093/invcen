@extends('layouts.template')

@section('content')



<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Plan de compras de la categoría: {{$categoria->titulo_especifico}}</strong>
			</h4>
		</div>
		<div class="panel-body">

    <div>
        <a href="{{route('plandecompras.excel.categoria.ind', $categoria->id)}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
        <a href="{{route('plandecompras.pdf.categoria.ind', $categoria->id)}}" class="btn btn-danger" title="DescargarPDF">Descargar en PDF</a>
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
                <th>Proveedor</th>
                <th>Nuevo proveedor</th>
                <th>Teléfono</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Cotización</th>
                <th>Finalizar</th>
            </tr>
            </thead>
            <tbody>

                @foreach ($planDelUsuario as $a)

                    <tr>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$categoria->titulo_especifico}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>{{$a->unidad}}</td>
                        <td>{{$a->proveedor}}</td>
                        <td>
                            @foreach ($proveedores as $p)
                                @if ($p->telefono == $a->nuevoproveedor)
                                    {{$p->nombre}}
                                @endif
                            @endforeach                           
                        </td>
                        <td>{{$a->nuevoproveedor}}</td>
                        <td>${{ round($a->precio_unitario,2) }}</td>
                        <td>${{ round(($a->total),2) }}</td>                        
                        <td>
                            @if($a->cotizacion)
                            <a class="btn btn-secondary btn-sm"  title="Descargar" href="{{route('pladecompras.descargar', $a->cotizacion) }}"><span class="fa fa-download fa-2x"></span></a>
                           @else
                                No hay cotización
                           @endif
                        </td>
                        <td>
                            <a onclick="return confirm('¿Eliminar producto del plan de compras?')" href="{{route('plandecompras.finalizarCompra', $a->id)}}" class="btn btn-danger btn-sm" title="Eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>
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
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection