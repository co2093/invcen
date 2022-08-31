@extends('layouts.template')

@section('content')


<div class="panel panel-info">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Historial de Plan de compras General</strong>
			</h4>
		</div>
		<div class="panel-body">


   <div>
        <a href="{{route('plandecompras.excel.historial.general')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
    </div> 
    


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Cantidad aprobada</th>
                <th>Nombre del bien</th>
                <th>Especificaciones técnicas</th>
                <th>Categoria</th>
                <th>Unidad de medida y presentacion</th>
                <th>Precio unitario</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @if($historialGeneral)
                @foreach ($historialGeneral as $a)

                    <tr>
                        <td>{{$a->cantidad_aprobada}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>{{$a->categoria}}</td>
                        <td>{{$a->unidad}}</td>
                        <td>${{ round($a->precio_unitario,2) }}</td>
                        <td>${{ round(($a->total),2) }}</td>
                        
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