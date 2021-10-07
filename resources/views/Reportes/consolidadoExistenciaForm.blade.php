@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href=" {{ asset('bootstrap/css/jquery-ui.min.css') }}">
@endsection

@section('content')

    <div class="panel panel-info">
        <div class="panel-heading" role="tab">
            <h2 class="panel-title">
                <strong>Reporte: Consolidado de existencias</strong>
            </h2>
        </div>
        <div class="panel-body">


            {!! Form::open(array('route' => 'reportes.consolidadoexistencia','class' => 'form-horizontal','method' => 'get')) !!}

            {{ csrf_field() }}

            <div class="form-group">
                {!!Form::label('fecha inicio', 'Fecha de inicio *', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">

                    {!!Form::text('fechainicio', null, array('placeholder' => '2016-11-20','class' => 'form-control calendario')) !!}

                    <div class="error">
                        <ul>@foreach($errors->get('fechainicio') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!!Form::label('fecha fin', 'Fecha de fin*', array('class' =>'col-md-2 control-label' )) !!}
                <div class="col-md-7">

                    {!!Form::text('fechafin', null, array('placeholder' => '2016-11-20','class' => 'form-control calendario')) !!}

                    <div class="error">
                        <ul>@foreach($errors->get('fechafin') as $msg)
                                <li>{{$msg}}</li> @endforeach</ul>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-7">
                    <button type="submit" class="btn btn-primary">Generar reporte</button>
                    <a href="{{route('reportes')}}" class="btn btn-primary">Cancelar</a>
                </div>
            </div>
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
