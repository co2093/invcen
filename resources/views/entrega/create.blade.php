@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <style>
        table{
            max-width: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h4 class="panel-title">
                <strong>Entrega de productos</strong>
            </h4>
        </div>
        <div class="panel-body">
            {!! Form::open(array('route' => 'producto.entrega.store','class' => 'form-horizontal','method' => 'post')) !!}

            {{ csrf_field() }}
            <div class="form-group">

                {!!Form::label('Solicitante', 'Solicitante *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    {!!Form::text('solicitante', null, array('placeholder' => 'Persona/Unidad que solicita','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('solicitante') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">

                {!!Form::label('Descripcion', 'Descripcion', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">
                    {!!Form::textarea('descripcion', null, array('placeholder' => 'Descripcion','class' => 'form-control')) !!}
                    <div class="error">
                        <ul>@foreach($errors->get('descripcion') as $msg)<li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>
            <hr/>
            {!!Form::label('Productos', 'Productos', array('class' =>'col-md-2 control-label' )) !!}
            <div class="table-responsive col-md-7">
                <table class="table table-hover table-striped table-condensed" id="Tablacontrolarticulo" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>Producto</th>
                        <th>Unidad de medida</th>
                        <th>Existencia</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach ($controlesarticulo as $controlarticulo)
                        <tr>
                            <td>
                            <input type="checkbox" name="productos[]" value="{{$controlarticulo->articulo->codigo_articulo}}"/>
                            </td>
                            <td>{{$controlarticulo->articulo->nombre_articulo}}</td>
                            <td>{{$controlarticulo->articulo->unidad->nombre_unidadmedida}}</td>
                            <td>{{$controlarticulo->existencia}}</td>
                            <td>
                                {!!Form::text($controlarticulo->articulo->codigo_articulo, 0, array('placeholder' => '10','class' => 'form-control')) !!}

                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


            <div class="form-group">
                <div class="col-md-offset-2 col-md-7">
                    <button type="submit" class="btn btn-primary">Entregar</button>
                    <a href="{{route('producto.controlexistencia')}}" class="btn btn-primary">Cancelar</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('plugins/select2/js/select2.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".js-example-basic-single").select2();
        });
    </script>
@endsection