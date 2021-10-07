@extends('layouts.template')

@section('content')

    <a href="{{ route('presentacion.create')}}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed">
            <thead>
            <tr class="success">
                <th>Presentacion</th>

                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($presentaciones as $presentacion)
                <tr>

                    <td>{{$presentacion->presentacion}}</td>

                    <td class="col-md-5">
                        <a class="btn btn-default btn-sm"
                           href="{{route('delete_presentacion',$presentacion->id_pres)}}"><span
                                    class="glyphicon glyphicon-trash"></span>Eliminar</a>
                        <a class="btn btn-default btn-sm"
                           href="{{route('presentacion.show',$presentacion->id_pres)}}"><span
                                    class="glyphicon glyphicon-th-large"></span>Detalle</a>
                        <a class="btn btn-default btn-sm"
                           href="{{route('presentacion.edit',$presentacion->id_pres)}}"><span
                                    class="glyphicon glyphicon-pencil"></span>Actualizar</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection


