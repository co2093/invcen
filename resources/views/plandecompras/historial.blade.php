@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Historial de Plan de compras de {{Auth::user()->name}}</strong>
			</h4>
		</div>
		<div class="panel-body">

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
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @if($planDelUsuario)
                @foreach ($planDelUsuario as $a)

                    <tr>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>${{ round($a->precio_unitario,2) }}</td>
                        <td>${{ round(($a->cantidad*$a->precio_unitario),2) }}</td>
                        <td>{{$a->proveedor}}</td>
                        <td>${{$a->cotizacion}}</td>
                        <td>{{$a->estado}}</td>
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