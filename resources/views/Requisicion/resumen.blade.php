@extends('layouts.template')


@section('content')

 <div class="encabezado">
        <h3>Resumen de solicitudes</h3>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaResumen" >
            <thead>
            <tr class="success">
                <th>C&oacute;digo</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Unidad de medida</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($solicitudes as $s)
                <tr>
                    <td>{{$s->codigo_articulo}}</td>
                    <td>{{$s->nombre_articulo}}</td>
                    <td>{{$s->cantidad}}</td>
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
                    "lengthChange": true,
                    "autoWidth": true
                });
        });
    </script>
@endsection
