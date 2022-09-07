@extends('layouts.template')

@section('content')

<div class="container">
<div class="panel panel-success">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title text-center">
				<strong>APROBAR</strong>
			</h4>
		</div>

                <div class="panel-body text-center">                   
                                <label class="control-label text-success">Seleccione confirmar para aprobar las siguientes compras.</label> 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3"><br>
                                <a href="{{ route('plandecompras.aprobar.confirmar', [$a, $b, $c, $d, $e]) }}" class="btn btn-success btn-block">CONFIRMAR</a>
                            </div>
                        </div>




        </div>	
</div>
</div>


<div class="panel panel-default">
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
				<strong>Detalles</strong>
			</h4>
		</div>
		<div class="panel-body">


    <div class="panel-body table-responsive ">

        <table class="table table-hover table-striped table-bordered table-condensed" id="TablaRequisicion">
            <thead>
            <tr>

                <th>Usuario</th>
                <th>Cantidad Solicitada</th>

                <th>Nombre del producto</th>
                <th>Categoría</th>
                <th>Especificaciones</th>
                <th>Proveedor</th>
                <th>Teléfono</th>
                <th>Precio unitario</th>
                <th>Total</th>
                
                <th>Añadir al plan</th>
                <th>Consultar en bodega</th>

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
                        <td>
                        @if($a->nuevoproveedor)
                            @foreach ($proveedores as $p)
                                @if ($p->telefono == $a->nuevoproveedor)
                                    {{$p->nombre}}
                                @endif
                            @endforeach                           
                        @else
                            {{$a->proveedor}}
                        @endif
                        </td>
                        <td>
                        @if($a->nuevoproveedor)
                            {{$a->nuevoproveedor}}
                        @else
                            @foreach ($proveedores as $p)
                                @if($a->proveedor == $p->nombre)
                                    {{$p->telefono}}
                                @endif
                            @endforeach
                        @endif

                        </td>
                        <td>${{ number_format(($a->precio_unitario),2,'.','') }}</td>
                        <td>${{ number_format(($articulo->total),2,'.','') }}</td>
                  
                        <td>
                            <a href="{{ route('plandecompras.aprobar', $a->id) }}" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>
                        </td>
                        <td>Bodega</td>

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