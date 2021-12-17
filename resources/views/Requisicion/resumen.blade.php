@extends('layouts.template')


@section('content')

 <div class="encabezado">
        <h3>Resumen de Solicitudes</h3>
    </div>

<a href="{{ route('plandecompras.pdf') }}" class="btn btn-success">Descargar PDF</a>
<a href="{{ route('plandecompras.excel') }}" class="btn btn-success">Descargar EXCEL</a>
<div class="panel-body table-responsive ">

  
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaResumen" >
            <thead>
            <tr class="success">
                <th>Cantidad</th>
                <th>Nombre del producto</th>
                <th>Especificaciones</th>
                <th>Precio unitario</th>
                <th>Costo total</th>
                <th>Proveedor</th>
                <th>Cotización</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($solicitudes as $s)
                <tr>
                    <td>{{$s->cantidad}}</td>
                    <td>{{$s->nombre_articulo}}</td>
                    <td>-</td>
                    <td>${{round($s->precio_unitario,2)}}</td>
                    <td>${{round($s->precio_unitario,2)*$s->cantidad}}</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>



@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#TablaResumen').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });
    </script>
@endsection
