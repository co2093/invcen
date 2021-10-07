@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Solicitudes</h3>
    </div>
    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisiciones">
            <thead>
            <tr class="success">
                <th>N&uacute;mero</th>
                <th>Unidad/Usuario</th>
                <th>Fecha de Solicitud</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($requisicion as $r)

                <tr>
                    <td>{{$r->getNumero()}}</td>
                    <td>{{$r->departamento['name']}}</td>
                    <td>{{$r->getFechaSolicitud()}}</td>
                    <td>
                        @if($r->estado == 'editar')
                            <strong>En edici&oacute;n</strong>
                        @elseif($r->estado == 'denegado')
                            <strong class="text-danger">{{$r->estado}}</strong>
                        @else
                            {{$r->estado}}
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-default btn-sm" title="detalles" href="{{route('requisicion.detalle.show',$r->id)}}"><span class="glyphicon glyphicon-th-large "></span></a>
                        @if($r->estado == 'aprobada')
                            <a class="btn btn-default btn-sm" target="_blank" title="imprimir" href="{{url('requisicion/imprimir',$r->id)}}"><span class="glyphicon glyphicon-print "></span></a>
                            {{--<a class="btn btn-default btn-sm" title="Desechar" href="{{route('requisicion-desechar',$r->id)}}"><span class="glyphicon glyphicon-remove "></span></a>--}}
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

            $("#TablaRequisiciones").DataTable(
                {
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": false,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection