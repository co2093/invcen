@extends('layouts.template')

@section('content')

    <div class="col-md-offset-2">
        <h3>Agregar exisencia</h3>
    </div>
    <hr/>

    {!! Form::open(array('route' => 'ingreso.store','class' => 'form-horizontal','method' => 'post')) !!}

    {{ csrf_field() }}

    <div class="form-group">
        {!!Form::label('Producto', 'Producto', array('class' =>'col-md-2 control-label' )) !!}
        <div class="col-md-7">
            <select name="producto" class="form-control">
                @foreach ($articulos as $articulo)
                    <option value={{$articulo->codigo_articulo}}>
                        {{$articulo->nombre_articulo}}
                    </option>
                @endforeach
            </select>
            <div class="error">
                <ul>@foreach($errors->get('producto') as $msg)
                        <li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>

    <div class="form-group">
        {!!Form::label('Proveedor', 'Proveedor', array('class' =>'col-md-2 control-label' )) !!}
        <div class="col-md-7">
            <select name="proveedor" class="form-control">
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
        {!!Form::label('Fecha', 'Fecha', array('class' =>'col-md-2 control-label' )) !!}
        <div class="col-md-7">
            {!!Form::text('fecha', \Carbon\Carbon::now(), array('placeholder' => '2016-11-20','class' => 'form-control calendario')) !!}
            <div class="error">
                <ul>@foreach($errors->get('fecha') as $msg)
                        <li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('Cantidad', 'Cantidad', array('class' =>'col-md-2 control-label' )) !!}
        <div class="col-md-7">
            {!!Form::number('cantidad', null, array('placeholder' => '','class' => 'form-control')) !!}
            <div class="error">
                <ul>@foreach($errors->get('cantidad') as $msg)
                        <li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('Precio unitario', 'Precio', array('class' =>'col-md-2 control-label' )) !!}
        <div class="col-md-7">
            {!!Form::text('precio', null, array('placeholder' => '','class' => 'form-control')) !!}
            <div class="error">
                <ul>@foreach($errors->get('precio') as $msg)
                        <li>{{$msg}}</li> @endforeach</ul>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-7">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="javascript:window.history.back();" class="btn btn-primary">Cancelar</a>
        </div>
    </div>
    {!!Form::hidden('mostrar',"ingresoindex", array('placeholder' => '')) !!}

    {!! Form::close() !!}

    <script>
        $(function () {
            $(".calendario").datepicker({
                appendText: "(yy-mm-dd)",
                dateFormat: "yy-mm-dd",

            });
        });
    </script>
@endsection 
