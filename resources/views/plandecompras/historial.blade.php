@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Historial de Plan de compras de {{Auth::user()->name}}</strong>
			</h4>
		</div>
		<div class="panel-body">


   <div>
        <a href="{{route('plandecompras.excel.historial')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
    </div> 
    


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Cantidad solicitada</th>
                <th>Nombre del producto</th>
                <th>Especificaciones</th>
                <th>Unidad de medida</th>
                <th>Proveedor</th>
                <th>Nuevo proveedor</th>
                <th>Teléfono</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Cantidad aprobada</th>
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
                        <td>${{ number_format(($a->precio_unitario),2,'.','') }}</td>
                        <td>${{ number_format(($a->precio_unitario*$a->cantidad_aprobada),2,'.','') }}</td>
                        <td>{{$a->cantidad_aprobada}}</td>
                        <td>{{$a->estado}}</td>
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
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection