@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Plan de compras de {{Auth::user()->name}}</strong>
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
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Proveedor</th>
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
                        <td>${{ round($a->precio_unitario,2) }}</td>
                        <td>${{ round(($a->cantidad*$a->precio_unitario),2) }}</td>
                        <td>{{$a->proveedor}}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm"  title="Descargar" href="{{route('descargarFile', $a->cotizacion) }}"><span class="fa fa-download fa-2x"></span></a>
                        </td>
                        <td>
                        	<a href="{{route('plandecompras.edit', $a->id)}}" class="btn btn-default btn-sm" title="Editar">
                            <span class="glyphicon glyphicon-pencil">
                        </td>
                        <td>
                        	<a href="{{route('plandecompras.deleteProduct', $a->id)}}" class="btn btn-danger btn-sm" title="Eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </td>
                    </tr>

                @endforeach
            @endif
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
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection