@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Resumen del plan de compras</strong>
			</h4>
		</div>
		<div class="panel-body">

    <div>
        <a href="{{route('plandecompras.resumen.excel')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
        <a href="{{route('plandecompras.resumen.pdf')}}" class="btn btn-danger" title="DescargarPDF">Descargar en PDF</a>
    </div>


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Cantidad</th>
                <th>Nombre del producto</th>
                <th>Especificaciones</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Proveedor</th>
                <th>Cotización</th>
            </tr>
            </thead>
            <tbody>

                @foreach ($planDelUsuario as $a)

                    <tr>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>${{ round($a->precio_unitario,2) }}</td>
                        <td>${{ round(($a->cantidad*$a->precio_unitario),2) }}</td>
                        <td>{{$a->proveedor}}</td>
                        <td>$ {{round(($a->cotizacion),2)}} </td>
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
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection