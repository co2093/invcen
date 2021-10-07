@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3 style="display: inline-block;">Oferta y demanda</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaExistencia">
            <thead>
            <tr class="success">
                <th>Especifico</th>
                <th>C&oacute;d. prod</th>
                <th>Producto</th>
                <th>Unidad de medida</th>
                <th>Existencia</th>
                <th>Cantidad solicitada</th>
                <th>Reservado</th>
                <th>No reservado</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($ofertaDemanda as $od)
                <tr>
                    <td>{{$od->especifico}}</td>
                    <td>{{(int)substr($od->codigo_articulo,7)}}</td>
                    <td>{{$od->articulo}}</td>
                    <td>{{$od->unidad}}</td>
                    @if ($od->existencia == 0)
                        <td style="color: red;">{{$od->existencia}}</td>
                    @else
                        <td >{{$od->existencia}}</td>
                    @endif
                    <td>{{$od->solicitud}}</td>
                    <td>{{$od->proceso}}</td>
                    <td>{{$od->quedan}}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#TablaExistencia').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false,
                });
        });
    </script>
@endsection
