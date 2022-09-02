@extends('layouts.template')

@section('content')


<div class="panel panel-info">
    <div class="panel-heading">
        <h4 class="panel-title"><strong>Resumen del plan de compras</strong></h4>
    </div>
    <div class="panel-body">

    <form method="POST" action="{{route('plandecompras.filter')}}">
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
				<strong>Resumen del plan de compras general</strong>
			</h4>
		</div>
		<div class="panel-body">

    <div>
        <a href="{{route('plandecompras.resumen.excel')}}" class="btn btn-success" title="DescargarExcel">Descargar en Excel</a>
        <a href="{{route('plandecompras.resumen.pdf')}}" class="btn btn-danger" title="DescargarPDF">Descargar en PDF</a>
    </div>


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>
                <th>Cantidad solicitada</th>
                <th>Nombre del producto</th>
                
                <th>Especificaciones Técnicas</th>
                <th>Categoría</th>
                <th>Unidad de medida</th>
                <th>Precio unitario</th>
                <th>Costo Total</th>
                <th>Añadir al plan</th>
                <th>Consultar en bodega</th>
            </tr>
            </thead>
            <tbody>

                @foreach ($planDelUsuario as $a)

                    <tr>
                        <td>{{$a->cantidad}}</td>
                        <td>{{$a->nombre_producto}}</td>
                        <td>{{$a->especificaciones}}</td>
                        <td>{{$a->categoria}}</td>
                        <td>{{$a->unidad}}</td>
                        <td>${{ number_format(($a->precio_unitario),2,'.','') }}</td>
                        <td>${{ number_format(($a->cantidad*$a->precio_unitario),2,'.','') }}</td>
                        <td>
                            <a href="{{ route('plandecompras.aprobar.general', [$a->nombre_producto, $a->especificaciones, $a->categoria, $a->unidad, $a->precio_unitario]) }}" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>
                        </td>
                        <td>
                            <a href="{{ route('plandecompras.consultar.general', [$a->nombre_producto]) }}" class="btn btn-info"><span class="glyphicon glyphicon-info-sign"></span>                            
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
                    "searching": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": true
                });
        });


    </script>
@endsection