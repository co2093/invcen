@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Unidad/Usuario</h3>
    </div>
    <a href="{{ route('departamento.create')}}" class="btn btn-success" title="Nuevo departamento"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>
    <div class="panel-body table-responsive ">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaDeptos">
            <thead>
            <tr class="success">
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Encargado</th>
                <th>Email</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($departamento as $d)
                <tr>
                    <td>{{$d->name}}</td>
                    <td>{{$d->descripcion}}</td>
                    <td>{{$d->encargado}}</td>
                    <td>
                        {{$d->usuarios['email']}}
                    </td>
                    <td class="col-md-2">
                        <a class="btn btn-default btn-sm" href="{{route('departamento.show',$d->id)}}" title="Eliminar"><span class="glyphicon glyphicon-trash"></span></a>
                        <a class="btn btn-default btn-sm" href="{{route('departamento.edit',$d->id)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                        @if($d->usuarios ==  null)
                        <a class="btn btn-default btn-sm" href="{{route('usuario-departamento',$d->id)}}" title="Agregar usuario"><span class="glyphicon glyphicon-user"></span></a>
                        @endif
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


