@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
@endsection

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h2 class="panel-title">
                <strong>Agregar existencia</strong>
            </h2>
        </div>
        <div class="panel-body">

            <div class="information">
                <strong>Espec&iacute;fico: </strong>{{$articulo->especifico->getEspecificoTitulo()}}<br/>
                <strong>C&oacute;d. prod: </strong>{{$articulo->getCodigoArticuloReporte()}}<br/>
                <strong>Producto: </strong>{{$articulo->nombre_articulo}}<br/>
                <Strong>Existencia: </strong>{{$articulo->existencia}}<br/>
                <strong>Precio Actual : </strong> ${{number_format($articulo->precio_unitario,2,'.','')}}<br/>
                <strong>Monto: </strong>${{$ingreso->num_factura}}
                <hr/>
            </div>

            {!! Form::open(array('route' => 'ingreso.store','class' => 'form-horizontal','method' => 'post')) !!}

            {{ csrf_field() }}

            {!!Form::hidden('producto', $articulo->codigo_articulo, array('placeholder' => '')) !!}

            <div class="form-group">
                {!!Form::label('Proveedor', 'Proveedor *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    <select name="proveedor" class="form-control js-example-basic-single js-example-responsive"
                            style="width: 100%">
                        @foreach ($proveedores as $proveedor)
                            <option value={{$proveedor->id}}>
                                {{$proveedor->nombre}}
                            </option>
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
                    {!!Form::text('orden', null, array('placeholder' => '','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('orden') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!!Form::label('Numero de factura', 'Numero de factura *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    {!!Form::text('factura', null, array('placeholder' => '','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('factura') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!!Form::label('Fecha', 'Fecha *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">

                    {!!Form::text('fecha', null, array('placeholder' => 'YYYY-mm-dd','class' => 'form-control calendario')) !!}

                    <div class="error">
                        <ul>@foreach($errors->get('fecha') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!!Form::label('Cantidad', 'Cantidad *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    {!!Form::number('cantidad','', array('placeholder' => '','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('cantidad') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>            
            <div class="form-group">
                {!!Form::label('Precio unitario', 'Precio *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    {!!Form::text('precio', null, array('placeholder' => '','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('precio') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>
            
            @if($articulo->es_reactivo == 'S')
                
                <div class="form-group">
                    {!!Form::label('marca', 'Marca', array('class' =>'col-md-2 control-label' )) !!}
                    <div class="col-md-7">
                        {!!Form::text('marca','', array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('marca') as $msg)
                                    <li>{{$msg}}</li> @endforeach</ul>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('casa', 'Casa', array('class' =>'col-md-2 control-label' )) !!}
                    <div class="col-md-7">
                        {!!Form::text('casa','', array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
                        <div class="error">
                            <ul>@foreach($errors->get('casa') as $msg)
                                    <li>{{$msg}}</li> @endforeach</ul>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!!Form::label('fecha_expira', 'Fecha expiración', array('class' =>'col-md-2 control-label' )) !!}
                    <div class="col-md-7">
                        {!!Form::text('fecha_expira','', array('placeholder' => '','class' => 'form-control calendario','required'=>'true')) !!}
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
                    <a href="{{route('articulo.index')}}" class="btn btn-primary">Cancelar</a>
                </div>
            </div>
            {!!Form::hidden('mostrar', "existenciaindex", array('placeholder' => '')) !!}

            {!! Form::close() !!}
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('bootstrap/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.js')}}"></script>
    <script type="text/javascript">
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
