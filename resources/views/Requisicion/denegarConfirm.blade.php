@extends('layouts.template')

@section('content')


    <div class="panel-body table-responsive">

        <div class="box-header with-border">
            <h3 class="box-title">¿Esta seguro que desea denegar la solicitud?</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <div class="form-horizontal">
            {!!Form::open(['route'=>['requisicion.denegado',$requisicion->id],'method'=>'post'])!!}
            {{ csrf_field() }}
            <div class="panel panel-default">
                <table class="table table-hover ">
                    <tr class="row">
                        <th class="col-xs-2">N&uacute;mero</th>
                        <td class="col-xs-7">{{$requisicion->getNumero()}}</td>
                        <td class="col-xs-3"></td>
                    </tr>
                    <tr class="row">
                        <th class="col-xs-2">Unidad/Usuario</th>
                        <td class="col-xs-7">{{$requisicion->departamento['name']}}</td>
                        <td class="col-xs-3"></td>
                    </tr>
                    <tr class="row">
                        <th class="col-xs-2">Fecha Solicitud</th>
                        <td class="col-xs-7">{{$requisicion->getFechaSolicitud()}}</td>
                        <td class="col-xs-3"></td>
                    </tr>
                </table>
            </div>

            <div class="">
                <a href="javascript:window.history.back();">
                    <button type="button" id="cancelar" class="btn btn-default m-t-10">Cancelar</button>
                </a>
                <button type="submit" class="btn btn-danger">Denegar</button>
            </div><!-- /.box-footer -->
            {!!Form::close()!!}
        </div>


    </div>
@endsection





