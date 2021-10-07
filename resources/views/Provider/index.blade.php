@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Proveedores</h3>
    </div>

    <a href="{{route('proveedor.create')}}" class="btn btn-success" title="Nuevo proveedor"><span class="glyphicon glyphicon-plus"></span>Nuevo</a>

    <div class="panel-body table-responsive">

        @include('Msj.messages')
        @include('Provider.detail')


        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaProveedores">
            <thead>
            <tr class="success">

                <th >Nombre</th>
                <th >Telefono</th>
                <th >Opciones</th>
            </tr>

            </thead>
            <tbody>
            @foreach ($proveedores as $p)
                <tr>
                    <td>{{$p->nombre}}</td>
                    <td>{{$p->telefono}}</td>
                    <td >
                        <a class="btn btn-default btn-sm" title="Eliminar" href="{{route('proveedor.show',$p->id)}}"><span class="glyphicon glyphicon-trash "></span></a>


                        <a class="btn btn-default btn-sm" title="Detalle" href="#detalles"  onClick="mostrar_provider({{$p->id}})" data-target="p-modal"><span class="glyphicon glyphicon-th-large "></span></a>

                        <a class="btn btn-default btn-sm" title="Editar" href="{{route('proveedor.edit',$p->id)}}"><span class="glyphicon glyphicon-pencil "></span></a>

                        <a class="btn btn-default btn-sm" title="Ver productos" href="{{route('productos-list',$p->id)}}"><span class="glyphicon glyphicon-list "></span></a>

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

            $('#TablaProveedores').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });

        var mostrar_provider= function(id){
            var route = "{{url('proveedor/detail')}}/"+id;
            $.get(route,function(data){
                $("#name").replaceWith( "<span id='name'>"+data.nombre+"</span>" );
                $("#dir").replaceWith( "<span id='dir'>"+data.direccion+"</span>" );
                $("#tel").replaceWith( "<span id='tel'>"+data.telefono+"</span>" );
                $("#mail").replaceWith( "<span id='mail'>"+data.email+"</span>" );
                $("#vendedor").replaceWith( "<span id='vendedor'>"+data.vendedor+"</span>" );
                $("#p-modal").modal();
            });
        }
    </script>

@endsection