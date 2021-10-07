@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Existencias</h3>
    </div>
    <a href="{{route('producto.entrega.create')}}" class="btn btn-success" title="Entregar productos"><span class="glyphicon glyphicon-plus"></span>Entregar productos</a>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="Tablacontrolarticulo" >
            <thead>
            <tr class="success">
                <th>Producto</th>
                <th>Unidad de medida</th>
                <th>Ultima entrega</th>
                <th>Existencia</th>
                {{--<th>Opciones</th>--}}
            </tr>
            </thead>
            <tbody>

            @foreach ($controlesarticulo as $controlarticulo)
                <tr>
                    <td>{{$controlarticulo->articulo->nombre_articulo}}</td>
                    <td>{{$controlarticulo->articulo->unidad->nombre_unidadmedida}}</td>
                    <td>{{$controlarticulo->entregado}}</td>
                    <td>{{$controlarticulo->existencia}}</td>

                   {{-- <td class="col-md-3">
                        <a class="btn btn-default btn-sm" href="{{route('delete_controlarticulo',$controlarticulo->codigo_controlarticulo)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('controlarticulo.show',$controlarticulo->codigo_controlarticulo)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('controlarticulo.edit',$controlarticulo->codigo_controlarticulo)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('addExistencia',$controlarticulo->codigo_controlarticulo)}}" title="Agregar existencia"><span class="glyphicon glyphicon-book"></span></a>


                    </td>
--}}
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#Tablacontrolarticulo').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });
    </script>
@endsection


