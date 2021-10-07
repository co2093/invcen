@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Productos que puedes solicitar</h3>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaArticulo" >
            <thead>
            <tr class="success">
                <th>Espec&iacute;fico</th>
                <th>C&oacute;d. prod.</th>
                <th>Producto</th>
                <th>Unidad de medida</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($articulos as $articulo)
                <tr>
                    <td>{{$articulo->id_especifico}}</td>
                    <td>{{$articulo->getCodigoArticuloReporte()}}</td>
                    <td>{{$articulo->nombre_articulo}}</td>
                    <td>{{$articulo->unidad->nombre_unidadmedida}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#TablaArticulo').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });
    </script>
@endsection


