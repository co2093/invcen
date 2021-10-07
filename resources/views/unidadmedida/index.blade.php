@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Unidades de medida</h3>
    </div>

    <a href="{{ route('unidad.create')}}" class="btn btn-success" title="Nueva unidad"><span class="glyphicon glyphicon-plus"></span> Nuevo</a>
    <div class="table-responsive">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaUnidadMedida">
            <thead>
            <tr class="success">

                <th>Unidad</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($unidades as $unidad)
                <tr>

                    <td>{{$unidad->nombre_unidadmedida}}</td>
                    <td class="col-md-3">
                        <a class="btn btn-default btn-sm" href="{{route('delete_unidad',$unidad->id_unidad_medida)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('unidad.show',$unidad->id_unidad_medida)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('unidad.edit',$unidad->id_unidad_medida)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#TablaUnidadMedida').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });
    </script>
@endsection


