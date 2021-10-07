@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
@endsection
@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h2 class="panel-title">
                <strong>Actualizar ingreso</strong>
            </h2>
        </div>
        <div class="panel-body">

            <div class="information">

                @if($ingreso)
                    <dl class="dl-horizontal">
                        <dt>Transaccion:</dt>
                        <dd>{{ $ingreso->id_ingreso}}</dd>
                        <dt>Fecha:</dt>
                        <dd>{{ $ingreso->transaccion->getFecha()}}</dd>
                        <dt>Numero de orden:</dt>
                        <dd>{{ $ingreso->orden }}</dd>
                        <dt>Numero de factura:</dt>
                        <dd>{{$ingreso->num_factura}}</dd>
                        <dt>Espec&iacute;fico</dt>
                        <dd>{{$ingreso->transaccion->articulo->id_especifico}}</dd>
                        <dt>Cod. Producto:</dt>
                        <dd>{{$ingreso->transaccion->articulo->getCodigoArticuloReporte()}}</dd>

                        <dt>Articulo:</dt>
                        <dd>{{ $ingreso->transaccion->articulo->nombre_articulo}}</dd>
                        <dt>Proveedor:</dt>
                        <dd>{{$ingreso->proveedor->nombre}}</dd>
                        <dt>Unidad:</dt>
                        <dd>{{ $ingreso->transaccion->articulo->unidad->nombre_unidadmedida}}</dd>
                        <dt>Cantidad:</dt>
                        <dd>{{ $ingreso->transaccion->cantidad}}</dd>
                        <dt>Precio unitario:</dt>
                        <dd>${{number_format($ingreso->transaccion->pre_unit,2,'.','')}}</dd>
                        <hr/>
                        <div class="col-md-offset-1">
                            <h4>Existencia anterior</h4>
                        </div>
                        <dt>Existencia:</dt>
                        <dd>{{ $ingreso->transaccion->exis_ant}}</dd>
                        <dt>Precio unitario:</dt>
                        <dd>${{number_format($ingreso->pre_unit_ant,2,'.','')}}</dd>
                        <div class="col-md-offset-1">
                            <h4>Existencia Posterior</h4>
                        </div>
                        <dt>Existencia:</dt>
                        <dd>{{ $ingreso->transaccion->exis_nueva}}</dd>
                        <dt>Precio unitario:</dt>
                        <dd>${{number_format($ingreso->pre_unit_nuevo,2,'.','')}}</dd>


                    </dl>
                    {!! Form::open(array('route' => ['ingreso.update','idIngreso' => $ingreso->id_ingreso],'class' => 'form-horizontal','method' => 'put')) !!}

                    {{ csrf_field() }}
                    <div class="form-group">
                        {!!Form::label('Proveedor', 'Proveedor *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">
                            <select name="proveedor" class="form-control js-example-basic-single js-example-responsive"
                                    style="width: 100%">

                                @foreach ($proveedores as $proveedor)
                                    @if($ingreso->proveedor->id == $proveedor->id)
                                        <option value={{$proveedor->id}} selected>
                                            {{$proveedor->nombre}}
                                        </option>
                                    @else
                                        <option value={{$proveedor->id}} >
                                            {{$proveedor->nombre}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="error">
                                <ul>@foreach($errors->get('proveedor') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Numero de orden', 'Numero de orden *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">
                            {!!Form::text('orden', $ingreso->orden, array('placeholder' => '','class' => 'form-control')) !!}
                            <div class="error">
                                <ul>@foreach($errors->get('orden') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Numero de factura', 'Numero de factura *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">
                            {!!Form::text('factura', $ingreso->num_factura, array('placeholder' => '','class' => 'form-control')) !!}
                            <div class="error">
                                <ul>@foreach($errors->get('factura') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Fecha', 'Fecha *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">

                            {!!Form::text('fecha', $ingreso->transaccion->fecha_registro, array('placeholder' => '2016-11-20','class' => 'form-control calendario')) !!}

                            <div class="error">
                                <ul>@foreach($errors->get('fecha') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('Cantidad', 'Cantidad *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">
                            {!!Form::number('cantidad', $ingreso->transaccion->cantidad, array('placeholder' => '','class' => 'form-control')) !!}
                            <div class="error">
                                <ul>@foreach($errors->get('cantidad') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!!Form::label('Precio unitario', 'Precio *', array('class' =>'col-md-2 control-label' )) !!}
                        <div class="col-md-7">
                            {!!Form::text('precio', $ingreso->transaccion->pre_unit, array('placeholder' => '','class' => 'form-control')) !!}
                            <div class="error">
                                <ul>@foreach($errors->get('precio') as $msg)
                                        <li>{{$msg}}</li> @endforeach</ul>
                            </div>
                        </div>
                    </div>
                    @if($ingreso->transaccion->articulo->es_reactivo == 'S')
                        
                        <div class="form-group">
                            {!!Form::label('marca', 'Marca', array('class' =>'col-md-2 control-label' )) !!}
                            <div class="col-md-7">
                                {!!Form::text('marca',$ingreso->marca, array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
                                <div class="error">
                                    <ul>@foreach($errors->get('marca') as $msg)
                                            <li>{{$msg}}</li> @endforeach</ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('casa', 'Casa', array('class' =>'col-md-2 control-label' )) !!}
                            <div class="col-md-7">
                                {!!Form::text('casa',$ingreso->casa, array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
                                <div class="error">
                                    <ul>@foreach($errors->get('casa') as $msg)
                                            <li>{{$msg}}</li> @endforeach</ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('fecha_expira', 'Fecha expiración', array('class' =>'col-md-2 control-label' )) !!}
                            <div class="col-md-7">
                                {!!Form::text('fecha_expira',$ingreso->fecha_expira, array('placeholder' => '','class' => 'form-control calendario','required'=>'true')) !!}
                                <div class="error">
                                    <ul>@foreach($errors->get('fecha_expira') as $msg)
                                            <li>{{$msg}}</li> @endforeach</ul>
                                </div>
                            </div>
                        </div>     
                           
                         
                    @endif

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-7">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{route('ingreso.index')}}" class="btn btn-primary">Cancelar</a>
                        </div>
                    </div>
                    {!!Form::hidden('mostrar', "existenciaindex", array('placeholder' => '')) !!}

                    {!! Form::close() !!}

                @endif

            </div>


        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('bootstrap/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.js')}}"></script>
    <script>
        $(function () {
            $(".calendario").datepicker({
                appendText: "(yy-mm-dd)",
                dateFormat: "yy-mm-dd",

            });
        });
        $(document).ready(function () {
            $(".js-example-basic-single").select2();
        });
    </script>
@endsection
