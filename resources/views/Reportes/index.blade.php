@extends('layouts.template')
@section('css')
    <style>
        .color{
            color: black;
        }
        .margen{
            margin-top: 10px;
            margin-bottom: 10px;
        }

    </style>
    @endsection
@section('content')
    <div class="encabezado">
        <h3>Reportes</h3>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte_kardexform')}}" class="color" target="_blank">
                    <img src="{{asset('dist/img/pdf_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Kardex</h3>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte_existenciaform')}}" class="color" target="_blank">
                    <img src="{{asset('dist/img/pdf_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Existencias</h3>
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte.existencia.form.excel')}}" class="color" target="_blank">
                    <img src="{{asset('dist/img/excel_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Existencias Excel</h3>
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte_consolidadoexistenciaform')}}" class="color" target="_blank">
                    <img src="{{asset('dist/img/pdf_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Consolidado de existencias</h3>
                </a>
            </div>
                <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte_historialproductoform')}}" class="color" target="_blank">
                    <img src="{{asset('dist/img/pdf_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Historial de producto</h3>
                </a>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12 margen text-center">

                <a href="{{ route('reporte.proveedores.pdf') }}" class="color" target="_blank">
                    <img src="{{asset('dist/img/pdf_report.png')}}" alt="imagen" class="img-responsive img-rounded center-block" />
                    <h3>Proveedores</h3>
                </a>
            </div>
        </div>
    </div>

@endsection




