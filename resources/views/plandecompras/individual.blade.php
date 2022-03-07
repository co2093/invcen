@extends('layouts.template')

@section('content')


<div class="panel panel-info">
    <div class="panel-heading">
        <h4 class="panel-title"><strong>Buscar por categoría</strong></h4>
    </div>
    <div class="panel-body">

    <form method="POST" action="{{route('plandecompras.filter.individual')}}">
        {{ csrf_field() }}

        <div class="form-group">
            <div class="col-xs-offset-3">
                <label>Categoría</label>

                    <select name="categoria" id="categoria" class="form-control">

                        @foreach($categorias as $c)
                            <option value="{{$c->id}}">{{$c->titulo_especifico}}</option>
                        @endforeach

                    </select>

            </div>
        </div>


        <div class="form-group">
            <div class="col-xs-offset-3">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>

     </form>   

    </div>
</div>


<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Plan de compras individual</strong>
			</h4>
		</div>
		<div class="panel-body">

    <div>
        <a href="{{route('plandecompras.individual.excel')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
        <a href="{{route('plandecompras.individual.pdf')}}" class="btn btn-danger" title="DescargarPDF">Descargar en PDF</a> 
    </div>


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Cantidad</th>
                <th>Nombre del producto</th>
                <th>Categoría</th>
                <th>Especificaciones</th>
                <th>Proveedor</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Cotización</th>
                <th>Finalizar</th>
            </tr>
            </thead>
            <tbody>

                @php
                    $nombre = "";
                @endphp

                @foreach ($planDelUsuario as $a)

                    @foreach($users as $u)
                            @if($a->user_id==$u->id)
                                @php
                                    $nombre = $u->name;
                                @endphp
                            @endif
                    @endforeach


                    <tr>
                        <td>{{$nombre}}</td>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->categoria}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>{{$a->proveedor}}</td>
                        <td>{{$a->precio_unitario}}</td>
                        <td>{{$a->cantidad*$a->precio_unitario}}</td>
                        <td>
                        @if($a->cotizacion)
                            <a class="btn btn-secondary btn-sm"  title="Descargar" href="{{route('pladecompras.descargar', $a->cotizacion) }}"><span class="fa fa-download fa-2x"></span></a>
                        @else
                            No hay cotización
                        @endif
                        </td>
                        <td>
                            <a onclick="return confirm('¿Eliminar producto del plan de compras?')" href="{{route('plandecompras.finalizarCompra', $a->id)}}" class="btn btn-danger btn-sm" title="Eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </td>
                    </tr>

                @endforeach
             

            </tbody>
        </table>
    </div>

    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $("#TablaRequisicion").DataTable(
                {
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection