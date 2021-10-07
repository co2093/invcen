@extends('layouts.template')

@section('content')
    <div class="encabezado">
        <h3>Entregas</h3>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaEntrega" >
            <thead>
            <tr class="success">
                <th>Solicitante</th>
                <th>Descripcion</th>
                <th>Fecha de entrega</th>
<th></th>
            </tr>
            </thead>
            <tbody>

            @foreach ($entregas as $entrega)
                <tr>

                    <td>{{$entrega->solicitante}}</td>
                    <td col-md-4>{{$entrega->descripcion}}</td>
                    <td>{{$entrega->fechaentrega}}</td>

                     <td class="col-md-2">

                         <a class="btn btn-default btn-sm" href="{{route('producto.entrega.edit',$entrega->identrega)}}" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>
                         <a class="btn btn-default btn-sm" href="{{route('producto.entrega.details',$entrega->identrega)}}" title="Detalle"><span class="glyphicon glyphicon-th-large"></span></a>

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

            $('#TablaEntrega').DataTable(
                {
                    "lengthChange": false,
                    "autoWidth": false
                });
        });
    </script>
@endsection


