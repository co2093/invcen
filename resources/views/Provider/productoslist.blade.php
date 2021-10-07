@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>{{$proveedor->nombre}}</h3>
    </div>
    <a href="{{ route('proveedor.index')}}" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span>Regresar</a>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaArticulo" >
            <thead>
            <tr class="success">
                <th>Nº</th>
                <th>Fecha</th>
                <th>Espec&iacute;fico</th>
                <th>C&oacute;d. prod.</th>
                <th>Producto</th>
                <th>Unidad de medida</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($proveedor->ingresos as $ingreso)
                <tr>
                    <td>{{$ingreso->id_ingreso}}</td>
                    <td>{{$ingreso->transaccion->getFecha()}}</td>
                    <td>{{$ingreso->transaccion->articulo->especifico->id}}</td>
                    <td>{{$ingreso->transaccion->articulo->getCodigoArticuloReporte()}}</td>
                    <td>{{$ingreso->transaccion->articulo->nombre_articulo}}</td>
                    <td>{{$ingreso->transaccion->articulo->unidad->nombre_unidadmedida}}</td>
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


