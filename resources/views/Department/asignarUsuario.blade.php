@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Agregar usuario a departamento</h3>
    </div>
    <div class="panel-body table-responsive ">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaDeptos">
            <thead>
            <tr class="success">
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Encargado</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($departamento as $d)
                <tr>
                    <td>{{$d->name}}</td>
                    <td>{{$d->descripcion}}</td>
                    <td>{{$d->encargado}}</td>
                    <td class="col-md-1">
                            <a class="btn btn-default btn-sm" href="{{url('usuario/create',$d->id)}}" title="Asignar usuario"><span class="glyphicon glyphicon-user" title="Añadir Usuario"></span></a>
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

            $('#TablaDeptos').DataTable(
                {
                    "lengthChange": false,
                });
        });
    </script>
@endsection


